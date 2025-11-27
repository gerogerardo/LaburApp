@extends('layouts.plantilla')
@section('titulo', 'Administración')

@section('contenido')

<div class="container">

    <h1 class="mb-4">Administración</h1>

    {{-- FILTRO POR MES --}}
    <form method="GET" action="{{ route('moderador') }}" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label for="mes" class="form-label">Filtrar por mes</label>
                <input 
                    type="month"
                    id="mes"
                    name="mes"
                    class="form-control"
                    value="{{ request('mes') }}"
                >
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    @if(isset($publicaciones) || isset($solicitudes))

        {{-- PUBLICACIONES --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Publicaciones creadas en {{ $mesNombre }}
            </div>

            <div class="card-body">
                <h4>Total: {{ $publicacionesTotales }}</h4>
                <hr>

                <h5>Por profesión:</h5>
                @if($publicaciones->count() > 0)
                    <ul class="list-group">
                        @foreach($publicacionesPorProfesion as $profesion => $cantidad)
                            <li class="list-group-item d-flex justify-content-between">
                                <span><h6>{{ $profesion }}</h6></span>
                                <span class="fw-bold">{{ $cantidad }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay publicaciones para este mes.</p>
                @endif
            </div>
        </div>

        {{-- SOLICITUDES --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                Solicitudes realizadas en {{ $mesNombre }}
            </div>

            <div class="card-body">
                <h4>Total: {{ $solicitudesTotales }}</h4>
                <hr>

                <h5>Por profesión:</h5>
                @if($solicitudes->count() > 0)
                    <ul class="list-group">
                        @foreach($solicitudesPorProfesion as $profesion => $cantidad)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $profesion }}</span>
                                <span class="fw-bold">{{ $cantidad }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay solicitudes para este mes.</p>
                @endif
            </div>
        </div>

    @endif

    <hr>

    {{-- GRÁFICOS --}}
    <h3 class="mt-5">Gráfico: Publicaciones por Profesión</h3>
    <canvas id="publicacionesChart" height="120"></canvas>

    <h3 class="mt-5">Gráfico: Solicitudes por Profesión</h3>
    <canvas id="solicitudesChart" height="120"></canvas>

    {{-- BOTÓN GENERAR REPORTE --}}
    <div class="mt-4">
    <a href="{{ route('moderador.pdf', ['mes' => request('mes') ?? '']) }}" class="btn btn-danger">
    <i class="fas fa-download"></i> GENERAR REPORTE
</a>
</div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Datos desde Laravel → JavaScript
    const publicacionesLabels = @json($publicacionesPorProfesion->keys());
    const publicacionesData   = @json($publicacionesPorProfesion->values());

    const solicitudesLabels = @json($solicitudesPorProfesion->keys());
    const solicitudesData   = @json($solicitudesPorProfesion->values());

    // === GRÁFICO PUBLICACIONES ===
    new Chart(document.getElementById('publicacionesChart'), {
        type: 'bar',
        data: {
            labels: publicacionesLabels,
            datasets: [{
                label: 'Cantidad',
                data: publicacionesData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });

    // === GRÁFICO SOLICITUDES ===
    new Chart(document.getElementById('solicitudesChart'), {
        type: 'bar',
        data: {
            labels: solicitudesLabels,
            datasets: [{
                label: 'Cantidad',
                data: solicitudesData,
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        }
    });

    // === CONVERTIR GRÁFICOS A BASE64 PARA EL PDF ===
    function generarImagenesGraficos() {
        const pubImg = document.getElementById('publicacionesChart').toDataURL();
        const solImg = document.getElementById('solicitudesChart').toDataURL();

        document.getElementById('inputGraficoPublicaciones').value = pubImg;
        document.getElementById('inputGraficoSolicitudes').value = solImg;
    }
</script>

@endsection
