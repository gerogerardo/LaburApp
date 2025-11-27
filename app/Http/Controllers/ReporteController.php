<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PublicacionesExport;

class ReporteController extends Controller
{
    public function reporte(Request $request)
    {
        $query = Publicacion::query();

        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $datos = $query->get();

        return view('reportes', compact('datos'));
    }
    }

