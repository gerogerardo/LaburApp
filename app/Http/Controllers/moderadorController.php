<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Publicacion;
use App\Models\Solicitudes;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SolicitudHecha;
use Intervention\Image\Facades\Image;

class moderadorController extends Controller
{

public function mod(Request $request)
{
    $mes = $request->get('mes') ?? Carbon::now()->format('Y-m');
    
    [$year, $month] = explode('-', $mes);

    $publicaciones = Publicacion::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->with('profesion')
                                ->get();

    $solicitudes = SolicitudHecha::whereYear('fecha', $year) 
                                 ->whereMonth('fecha', $month)
                                 ->with('publicacion.profesion')
                                 ->get();

    $publicacionesPorProfesion = $publicaciones->map(function($item) {
        return $item->profesion->nombre_profesion;
    })->countBy();

    $solicitudesPorProfesion = $solicitudes
        ->filter(function($item) {
            return $item->publicacion && $item->publicacion->profesion;
        })
        ->map(function($item) {
            return $item->publicacion->profesion->nombre_profesion;
        })
        ->countBy();

    return view('laburapp.moderador', [
        'mesNombre' => Carbon::createFromDate($year, $month)->translatedFormat('F Y'),
        'publicaciones' => $publicaciones,
        'solicitudes' => $solicitudes,
        'publicacionesTotales' => $publicaciones->count(),
        'solicitudesTotales' => $solicitudes->count(),
        'publicacionesPorProfesion' => $publicacionesPorProfesion,
        'solicitudesPorProfesion' => $solicitudesPorProfesion,
    ]);
}

public function exportPDF(Request $request)
{
    $mes = $request->get('mes') ?? Carbon::now()->format('Y-m');

    [$year, $month] = explode('-', $mes);

    $publicaciones = Publicacion::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->with('profesion')
                                ->get();

    $solicitudes = SolicitudHecha::whereYear('fecha', $year)
                                 ->whereMonth('fecha', $month)
                                 ->with('publicacion.profesion')
                                 ->get();

    $publicacionesPorProfesion = $publicaciones
        ->map(fn($p) => $p->profesion->nombre_profesion)
        ->countBy();

    $solicitudesPorProfesion = $solicitudes
        ->filter(fn($s) => $s->publicacion && $s->publicacion->profesion)
        ->map(fn($s) => $s->publicacion->profesion->nombre_profesion)
        ->countBy();

    // ✅ Generar gráficos en el servidor
    $imgPublicaciones = $this->generarGraficoBase64($publicacionesPorProfesion, 'Publicaciones');
    $imgSolicitudes = $this->generarGraficoBase64($solicitudesPorProfesion, 'Solicitudes');

    $data = [
        'mesNombre'                 => Carbon::createFromDate($year, $month)->translatedFormat('F Y'),
        'publicacionesTotales'      => $publicaciones->count(),
        'solicitudesTotales'        => $solicitudes->count(),
        'publicacionesPorProfesion' => $publicacionesPorProfesion,
        'solicitudesPorProfesion'   => $solicitudesPorProfesion,
        'imgPublicaciones'          => $imgPublicaciones,
        'imgSolicitudes'            => $imgSolicitudes,
    ];

    $pdf = PDF::loadView('laburapp.moderador-pdf', $data);

    return $pdf->download('reporte-' . $mes.'.pdf');
}


private function generarGraficoBase64($data, $titulo = '')
{
    $labels = $data->keys()->toArray();
    $values = $data->values()->toArray();

    $width  = 800;
    $height = 500;

    // Crear imagen en blanco
    $img = Image::canvas($width, $height, '#ffffff');

    // Escribir título
    $img->text($titulo, 400, 30, function($font) {
        $font->size(24);
        $font->align('center');
        $font->color('#000000');
    });

    if (count($values) > 0) {
        $maxValue = max($values);
        $barWidth = 40;
        $gap = 30;
        $x = 80;
        $yBottom = 420;

        foreach ($values as $i => $val) {
            $barHeight = ($val / $maxValue) * 300;

            // Dibujar barra
            $img->rectangle(
                $x,
                $yBottom - $barHeight,
                $x + $barWidth,
                $yBottom,
                function ($draw) {
                    $draw->background('#0066cc');
                }
            );

            // Etiqueta
            $img->text($labels[$i], $x + 20, $yBottom + 10, function($font) {
                $font->size(12);
                $font->color('#000000');
            });

            // Valor
            $img->text($val, $x + 15, $yBottom - $barHeight - 20, function($font) {
                $font->size(10);
                $font->color('#000000');
            });

            $x += $barWidth + $gap;
        }
    }

    // Convertir a base64
    $imgData = (string) $img->encode('png');
    return 'data:image/png;base64,' . base64_encode($imgData);
}
}  
