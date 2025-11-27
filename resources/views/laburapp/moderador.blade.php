@extends('layouts.app')

@section('contentido')
<div class="container">

    {{-- TÍTULO --}}
    <h1 class="mb-4">Reportes</h1>

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
                <button type="submit" class="btn btn-primary">
                    Filtrar
                </button>
            </div>
        </div>
    </form>

    {{-- RESULTADOS --}}
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
                                <span>{{ $profesion }}</span>
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

</div>
@endsection
