@extends('layouts.plantilla')
@section('titulo','Solicitudes')
@section('contenido')
<div class='seccion'>
    <h1>Solicitudes recibidas</h1>
@if ($solicitudes->isEmpty())
<div class="link">
    <p style="font-size: large;">No tienes solicitudes recibidas</p>
</div>
@else

<h3>Solicitudes recibidas</h3>

    @foreach ($solicitudes as $solicitud)
    
    <div class='bloque-solicitud'>
        <div class='texto-solicitudes'>
            <p>Tienes una solicitud de {{$solicitud->usuario->nombre}} {{$solicitud->usuario->apellido}} para la publicacion de <strong> "{{ $solicitud->publicacion->nombre_publicacion }}"</strong>
                <br> <br>
            Solicitado el día: </p>
        </div>
    </div>
@endforeach
    </div>

  


    @endif
    @endsection
