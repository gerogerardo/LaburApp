<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitudes;
use App\Models\Publicacion;


class solicitudesController extends Controller
{
    
        public function verSolicitudes() {
    if (Auth::check()) {
        
        $idsPublicaciones = Publicacion::where('id_usuario', Auth::id())->pluck('id_publicaciones');

        $solicitudes = Solicitudes::whereIn('id_publicaciones', $idsPublicaciones)
            ->with(['usuario', 'publicacion']) 
            ->get();

        return view('laburapp.ver_solicitudes', compact('solicitudes'));
    }
    return redirect()->route('login');
}

public function solicitar($id_publicaciones)
{
    $id_usuario = Auth::id(); 
    $publicacion = Publicacion::findOrFail($id_publicaciones);

    // Evitar que el usuario se solicite a sí mismo
    if ($publicacion->id_usuario == $id_usuario) {
        return redirect()->back()->with('error', 'No puedes solicitar una publicación creada por ti mismo');
    }

    // Verificar si ya existe una solicitud
    $existe = Solicitudes::where('id_usuario', $id_usuario)
        ->where('id_publicaciones', $id_publicaciones)
        ->exists();

    if (!$existe) {
        Solicitudes::create([
            'id_usuario' => $id_usuario,
            'id_publicaciones' => $id_publicaciones,
        ]);

        return redirect()->route('index')->with('success', 'Solicitud exitosa');
    }

    return redirect()->route('index')->with('error', 'Ya has solicitado esta publicación');
}

public function Mis_solicitudes(){
   if(Auth::check()){
    $id_usuario = Auth::id();

    $solicitudes = Solicitudes::where('id_usuario', $id_usuario)->with(['publicacion'])->get();
        return view ('laburapp.Mis_solicitudes', compact('solicitudes'));
    
    }else {
            return redirect()->route('inicioSesion.form')->withErrors(['error' => 'Debes iniciar sesión para ver tus publicaciones.']); 
        }
}

}