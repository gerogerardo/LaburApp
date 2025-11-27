<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use PDF; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $datos = $query->orderBy('created_at')->get();

        $counts = $datos
            ->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->map(function($group) {
                return $group->count();
            });

        $labels = $counts->keys()->map(function($d){
            return Carbon::parse($d)->format('d/m/Y');
        })->values();

        $values = $counts->values()->values();

        return view('reportes.index', [
            'datos' => $datos,
            'labels' => $labels,
            'values' => $values,
            'filtros' => $request->only(['desde','hasta','estado'])
        ]);
    }

    public function Pdf(Request $request)
    {
        $query = Publicacion::query();

        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $datos = $query->orderBy('created_at')->get();

        $pdf = PDF::loadView('reportes.tabla', compact('datos', 'request'));

        return $pdf->download('reporte.pdf');
    }
}