<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Publicacion;
use App\Models\Solicitudes;

class moderadorController extends Controller
{
    public function mod(Request $request)
    {
        $mes = $request->get('mes'); // Formato YYYY-MM

        if (!$mes) {
            return view('moderador');
        }

        [$year, $month] = explode('-', $mes);

        $publicaciones = Publicacion::whereYear('created_at', $year)
                                    ->whereMonth('created_at', $month)
                                    ->get();

        $solicitudes = Solicitudes::whereYear('created_at', $year)
                                  ->whereMonth('created_at', $month)
                                  ->get();

        return view('moderador', [
            'mesNombre' => Carbon::createFromDate($year, $month)->translatedFormat('F Y'),
            'publicaciones' => $publicaciones,
            'solicitudes' => $solicitudes,
            'publicacionesTotales' => $publicaciones->count(),
            'solicitudesTotales' => $solicitudes->count(),
            'publicacionesPorProfesion' => $publicaciones->groupBy('profesion')->map->count(),
            'solicitudesPorProfesion' => $solicitudes->groupBy('profesion')->map->count(),
        ]);
    }
}
