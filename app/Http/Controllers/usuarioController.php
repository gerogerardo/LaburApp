<?php

namespace App\Http\Controllers;
use App\Models\Localidad;

use App\Models\Usuario;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Rating;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudHecha;

class usuarioController extends Controller
{
    public function modificar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'informacion' => 'nullable|string|max:500',
            'telefono' => 'nullable|string|max:15',
            'domicilio' => 'nullable|string|max:255',
            'mail' => 'required|email|max:255',
            'id_localidad' => 'required|exists:localidades,id_localidad',
            'nueva-contraseña' => 'nullable|string',
        ]);

        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        $usuario->update($request->only([
            'nombre',
            'apellido',
            'informacion',
            'telefono',
            'domicilio',
            'mail',
            'id_localidad',
        ]));
        
                if ($request->filled('nueva-contraseña')) {
                    $usuario->contraseña = Hash::make($request->input('nueva-contraseña'));
                    $usuario->save();
                }

        if ($request ->hasFile('foto_perfil')) {
            $ruta = $request->file('foto_perfil')->store('imagenes','public');
            $usuario->foto_perfil = $ruta;
            $usuario->save();
        }

        return redirect()->route('perfil')->with('success', 'Usuario modificado correctamente.');
    } 
    
    public function editarPerfil() {
    $localidades = Localidad::all();
    $usuario = auth::user();
    return view('laburapp.modificarUsuario', compact('usuario', 'localidades'));;
}
    public function eliminarPerfil(){
        /** @var \App\Models\Usuario $usuario */
        $usuario = auth::user();
        auth::logout();
        $usuario ->delete();
        return redirect()->route('index')->with('success', 'Cuenta eliminada correctamente.');
    }
    public function verUsuario($id){
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $publicacion = Publicacion::findOrFail($id);
        if ($usuario && $usuario->id_usuario == $publicacion->id_usuario){
            return view('laburapp.perfil', ['usuario' => $usuario]);
        }
        else {
            $usuario = $publicacion->usuario;
            return view('laburapp.verPerfilDeOtro', compact('usuario'));
    }
    }

public function verPerfilDeOtroUsuario($id)
{
    $usuario = Usuario::findOrFail($id);
    $usuarioAutorizado= Auth::user();
    $tieneAcceso = false;

        if ($usuarioAutorizado) {
        $tieneAcceso = SolicitudHecha::where('id_del_solicitante', $usuarioAutorizado->id_usuario)
            ->where('id_del_solicitado', $usuario->id_usuario)
            ->exists();
    }


    // Obtener IDs de publicaciones del usuario
    $publicaciones = Publicacion::where('id_usuario', $id)
        ->pluck('id_publicaciones');

    // Inicializar variables
    $promedioGeneral = 0;
    $promedioPorProfesion = collect();

    if ($publicaciones->isNotEmpty()) {
        // Promedio general
        $promedioGeneral = Rating::whereIn('id_publicaciones', $publicaciones)
            ->avg('rating');
        $promedioGeneral = $promedioGeneral ? round($promedioGeneral, 2) : 0;

        // Promedio por profesión con join
        $promedioPorProfesion = Rating::join('publicaciones', 'rating.id_publicaciones', '=', 'publicaciones.id_publicaciones')
            ->join('profesiones', 'publicaciones.id_profesion', '=', 'profesiones.id_profesion')
            ->whereIn('rating.id_publicaciones', $publicaciones)
            ->select(
                'profesiones.nombre_profesion as profesion',
                DB::raw('ROUND(AVG(rating.rating), 2) as promedio'),
                DB::raw('COUNT(rating.id_rating) as cantidad_votos')
            )
            ->groupBy('profesiones.id_profesion', 'profesiones.nombre_profesion')
            ->get();
    }

    return view('laburapp.verPerfilDeOtro', [
        'usuario' => $usuario,
        'promedioGeneral' => $promedioGeneral,
        'promedioPorProfesion' => $promedioPorProfesion,
        'tieneAcceso' => $tieneAcceso
    ]);
}
}