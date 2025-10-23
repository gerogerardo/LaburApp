<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;      
use App\Models\Publicacion;   
use App\Models\Rating;      
use Illuminate\Support\Facades\DB;  

class PerfilController extends Controller
{
    public function perfil()
    {
        $usuario = Auth::user();
    }
public function verPerfil()
{
    // Obtener ID del usuario logueado
    $id_usuario = Auth::id();

    // Obtener IDs de publicaciones del usuario
    $publicaciones = Publicacion::where('id_usuario', $id_usuario)->pluck('id_publicaciones');

    // Inicializar variables para evitar "undefined variable"
    $promedioGeneral = 0;
    $promedioPorProfesion = collect(); // colección vacía

    if ($publicaciones->isNotEmpty()) {
        // Promedio general
        $promedioGeneral = Rating::whereIn('id_publicaciones', $publicaciones)->avg('rating');
        $promedioGeneral = $promedioGeneral ? round($promedioGeneral, 2) : 0;

        // Promedio por profesión con join
/*     $promedioPorProfesion = Rating::join('profesiones', 'rating.id_profesion', '=', 'profesiones.id_profesion')
            ->whereIn('rating.id_publicaciones', $publicaciones)
            ->select('profesiones.nombre_profesion as profesion', DB::raw('ROUND(AVG(rating.rating), 2) as promedio'))
            ->groupBy('profesiones.nombre_profesion')
            ->get();
    } */

    // Pasar variables a la vista
    return view('laburapp.perfil', [
        'promedioGeneral' => $promedioGeneral,
        'promedioPorProfesion' => $promedioPorProfesion
    ]);
}
}
}