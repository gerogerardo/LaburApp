@extends('layouts.plantilla')
@section('titulo','Solicitudes')
@section('contenido')
<div class='seccion'>
@if ($solicitudes->isEmpty())
    <h3>No tienes solicitudes recibidas</h3>
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
