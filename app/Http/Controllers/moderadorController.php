<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Publicacion;
use App\Models\Solicitudes;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SolicitudHecha;
use CpChart\Data;
use CpChart\Image;

/**
 * VERSIÓN CORREGIDA PARA LA API REAL DE CPCHART
 * 
 * Esta versión usa la estructura real de CpChart como está instalada en tu proyecto.
 * No usa la clase Bar que no existe, sino que dibuja las barras directamente
 * usando los métodos de la clase Image.
 */
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

        $publicacionesPorProfesion = $publicaciones->map(function ($item) {
            return $item->profesion->nombre_profesion;
        })->countBy();

        $solicitudesPorProfesion = $solicitudes
            ->filter(function ($item) {
                return $item->publicacion && $item->publicacion->profesion;
            })
            ->map(function ($item) {
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

        // Generar gráficos usando CpChart con la API correcta
        $imgPublicaciones = $this->generarGraficoCpChart(
            $publicacionesPorProfesion,
            'Publicaciones por Profesión',
            ['R' => 66, 'G' => 153, 'B' => 225] // Color azul
        );

        $imgSolicitudes = $this->generarGraficoCpChart(
            $solicitudesPorProfesion,
            'Solicitudes por Profesión',
            ['R' => 72, 'G' => 187, 'B' => 120] // Color verde
        );

        $data = [
            'mesNombre' => Carbon::createFromDate($year, $month)->translatedFormat('F Y'),
            'publicacionesTotales' => $publicaciones->count(),
            'solicitudesTotales' => $solicitudes->count(),
            'publicacionesPorProfesion' => $publicacionesPorProfesion,
            'solicitudesPorProfesion' => $solicitudesPorProfesion,
            'imgPublicaciones' => $imgPublicaciones,
            'imgSolicitudes' => $imgSolicitudes,
        ];

        $pdf = PDF::loadView('laburapp.moderador-pdf', $data);

        return $pdf->download('reporte-' . $mes . '.pdf');
    }


    /**
     * Genera un gráfico de barras profesional usando CpChart
     * 
     * VERSIÓN MEJORADA: Optimizada para máxima calidad de texto y legibilidad en PDF
     * - Mayor resolución para texto más nítido
     * - Fuentes TrueType con tamaños optimizados
     * - Mejor manejo de etiquetas largas
     * 
     * @param \Illuminate\Support\Collection $data - Colección con los datos
     * @param string $titulo - Título del gráfico
     * @param array $color - Color en formato ['R' => 0-255, 'G' => 0-255, 'B' => 0-255]
     * @return string - String en formato data:image/png;base64,...
     */
    private function generarGraficoCpChart($data, $titulo = '', $color = ['R' => 66, 'G' => 153, 'B' => 225])
    {
        // Convertir la colección a arrays
        $labels = $data->keys()->toArray();
        $values = $data->values()->toArray();

        // Si no hay datos, generar una imagen simple indicándolo
        if (empty($values)) {
            return $this->generarImagenSinDatos($titulo);
        }

        // Crear el objeto Data que contendrá nuestros datos
        $chartData = new Data();

        // Agregar los valores como una serie de datos
        $chartData->addPoints($values, 'Valores');

        // Agregar las etiquetas para el eje X
        $chartData->addPoints($labels, 'Etiquetas');
        $chartData->setAbscissa('Etiquetas');

        // Definir qué serie queremos graficar en el eje Y
        $chartData->setSerieOnAxis('Valores', 0);

        // MEJORA 1: Aumentar la resolución del gráfico para mejor calidad
        // Una resolución más alta significa más píxeles, lo que resulta en texto más nítido
        // Especialmente importante cuando se va a incluir en un PDF que se puede hacer zoom
        $width = 1200;  // Incrementado de 800 a 1200
        $height = 700;  // Incrementado de 500 a 700
        $image = new Image($width, $height, $chartData);

        // Configurar el fondo blanco
        $image->drawFilledRectangle(
            0,
            0,
            $width,
            $height,
            ['R' => 255, 'G' => 255, 'B' => 255]
        );

        // MEJORA 2: Cargar fuente TrueType con mejor manejo de errores
        // Las fuentes TrueType son vectoriales y se ven nítidas a cualquier tamaño
        $fontPath = $this->obtenerRutaFuenteCpChart();

        if ($fontPath && file_exists($fontPath)) {
            // MEJORA 3: Aumentar el tamaño base de la fuente para mejor legibilidad
            // Un tamaño mayor significa que las letras serán más claras en el PDF
            $image->setFontProperties([
                'FontName' => $fontPath,
                'FontSize' => 14  // Incrementado de 10 a 14 para mejor legibilidad
            ]);

            // Log para debugging - puedes comentar esto después de verificar que funciona
            \Log::info('CpChart usando fuente TrueType: ' . $fontPath);
        } else {
            // Si no hay fuente TrueType disponible, registrar el problema
            // Esto te ayudará a diagnosticar si las fuentes no se están cargando
            \Log::warning('CpChart: No se encontró fuente TrueType, usando fuente por defecto');
        }

        // MEJORA 4: Título con tamaño de fuente mayor para destacarlo
        $image->drawText(
            $width / 2,
            40,  // Ajustado para la nueva altura
            $titulo,
            [
                'FontSize' => 22,  // Incrementado de 16 a 22 para mejor visibilidad
                'Align' => TEXT_ALIGN_TOPMIDDLE,
                'R' => 0,
                'G' => 0,
                'B' => 0
            ]
        );

        // MEJORA 5: Ajustar el área del gráfico proporcionalmente a la nueva resolución
        // Dejamos más espacio abajo para las etiquetas rotadas
        $image->setGraphArea(120, 90, $width - 60, $height - 140);

        // MEJORA 6: Configuración mejorada de la escala con mejor manejo de etiquetas
        $image->drawScale([
            'GridR' => 200,
            'GridG' => 200,
            'GridB' => 200,
            'DrawSubTicks' => false,
            'CycleBackground' => false,
            'Mode' => SCALE_MODE_START0,
            'LabelRotation' => 45,  // Rotar a 45 grados para evitar superposición
            'LabelSkip' => 0,       // Mostrar todas las etiquetas
            'FontSize' => 12,       // Tamaño de fuente específico para las etiquetas de los ejes
        ]);

        // Configurar el color de las barras
        $chartData->setPalette('Valores', [
            'R' => $color['R'],
            'G' => $color['G'],
            'B' => $color['B'],
            'Alpha' => 100
        ]);

        // MEJORA 7: Configuración mejorada del gráfico de barras
        $image->drawBarChart([
            'DisplayValues' => true,
            'DisplayColor' => DISPLAY_MANUAL,
            'DisplayR' => 0,
            'DisplayG' => 0,
            'DisplayB' => 0,
            'Rounded' => true,
            'Surrounding' => 30,
            'DisplaySize' => 13,    // Tamaño de fuente para los valores sobre las barras
        ]);

        // Dibujar un borde alrededor del área del gráfico
        $image->drawRectangle(
            120,
            90,
            $width - 60,
            $height - 140,
            [
                'R' => 0,
                'G' => 0,
                'B' => 0
            ]
        );

        // MEJORA 8: Usar compresión PNG óptima para mantener calidad
        // El nivel 9 es la máxima compresión sin pérdida de calidad
        ob_start();
        imagepng($image->Picture, null, 9);  // 9 = máxima compresión sin pérdida
        $imageData = ob_get_clean();

        // Liberar la memoria
        imagedestroy($image->Picture);

        // Convertir a base64 y retornar
        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    /**
     * Busca una fuente TrueType en las ubicaciones donde CpChart las instala
     * 
     * @return string|null
     */
    private function obtenerRutaFuenteCpChart()
    {
        // Lista de posibles ubicaciones de fuentes en CpChart
        $fuentesPosibles = [
            base_path('vendor/szymach/c-pchart/resources/fonts/GeosansLight.ttf'),
            base_path('vendor/szymach/c-pchart/resources/fonts/pf_arma_five.ttf'),
            base_path('vendor/szymach/c-pchart/resources/fonts/Bedizen.ttf'),
            base_path('vendor/szymach/c-pchart/resources/fonts/calibri.ttf'),
            base_path('vendor/szymach/c-pchart/resources/fonts/Forgotte.ttf'),
            base_path('vendor/szymach/c-pchart/resources/fonts/MankSans.ttf'),
            base_path('vendor/szymach/c-pchart/resources/fonts/Silkscreen.ttf'),
            base_path('vendor/szymach/c-pchart/src/Resources/fonts/GeosansLight.ttf'),
            base_path('vendor/szymach/c-pchart/src/Resources/fonts/pf_arma_five.ttf'),
        ];

        foreach ($fuentesPosibles as $fuente) {
            if (file_exists($fuente)) {
                return $fuente;
            }
        }

        // Si no encuentra ninguna fuente TrueType, retornar null
        // CpChart usará una fuente por defecto
        return null;
    }

    /**
     * Genera una imagen simple cuando no hay datos para mostrar
     * 
     * @param string $titulo
     * @return string
     */
    private function generarImagenSinDatos($titulo)
    {
        $width = 800;
        $height = 500;

        $img = imagecreatetruecolor($width, $height);
        $blanco = imagecolorallocate($img, 255, 255, 255);
        $gris = imagecolorallocate($img, 100, 100, 100);

        imagefilledrectangle($img, 0, 0, $width, $height, $blanco);

        $mensaje = "No hay datos para mostrar";
        imagestring($img, 5, $width / 2 - 100, $height / 2 - 20, $titulo, $gris);
        imagestring($img, 4, $width / 2 - 100, $height / 2 + 10, $mensaje, $gris);

        ob_start();
        imagepng($img);
        $imageData = ob_get_clean();
        imagedestroy($img);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
