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
    $existe = Solicitudes::where('id_usuario', $id_usuario)
                            ->where('id_publicaciones', $id_publicaciones)
                            ->exists();

    $publicacion = Publicacion::find($id_publicaciones);

    $id_Usuario_publicacion = $publicacion->id_usuario;                        

    if ( $id_Usuario_publicacion  == $id_usuario) {
       return response("<script>
       alert('No podés solicitarte a vos mismo');
       window.location.href = '" . url()->previous() . "';
       </script>");
        
      }



    if (!$existe) {
        Solicitudes::create([
            'id_usuario' => $id_usuario,
            'id_publicaciones' => $id_publicaciones,
        ]);  
        

    return redirect()->route('index')->with('success', 'Solicitud exitosa');}
    return redirect()->route('index')->with('success', 'Ya se ha solicitado esta publicacion');
                                                                                                 
    
     
}
}
