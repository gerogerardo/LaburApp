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
        $id_usuario = Auth::id();
        $usuario = Auth::user();

        // Obtener IDs de publicaciones del usuario
        $publicaciones = Publicacion::where('id_usuario', $id_usuario)
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

        return view('laburapp.perfil', [
            'usuario' => $usuario,
            'promedioGeneral' => $promedioGeneral,
            'promedioPorProfesion' => $promedioPorProfesion
        ]);
    }
}
