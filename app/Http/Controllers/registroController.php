<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class RegistroController extends Controller
{
public function formularioRegistro()
{
    $localidades = DB::table('localidades')->orderBy('id_localidad')->get();
    return view('laburapp.registroUsuario', compact('localidades'));
}

public function guardarUsuario(Request $request)
{ 
        $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        'pass' => 'required',
        'mail' => 'required|email',
        'telefono' => 'required',
        'localidad' => 'required',
        'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', 
       
    ]);
     if ($request->hasFile('imagen') && $request->file('imagen')->getSize() > 2048 * 1024) {
        return redirect()->back()
            ->withErrors(['imagen' => 'La imagen no debe superar los 2MB'])
            ->withInput();
    }
    // Guardar imagen
    if ($request->hasFile('imagen')) {
        $imagenPath = $request->file('imagen')->store('imagenes', 'public');
    } else {
        return redirect()->back()->withErrors(['imagen' => 'Debe subir una imagen válida']);
    }

    // Crear el usuario
    Usuario::create([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'mail' => $request->mail,
        'telefono' => $request->telefono,
        'foto_perfil' => $imagenPath,
        'contraseña' => bcrypt($request->pass),
        'id_localidad' => $request->localidad,
        'domicilio' => '',
        'informacion' => '',
        'id_rating' => null,
        'rol' =>"usuario",
    ]);
    return redirect()->route('inicioSesion.usuario')->with('success', 'Usuario registrado correctamente');
}
}