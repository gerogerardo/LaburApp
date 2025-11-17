@extends('layouts.plantilla')
@section('titulo','Solicitudes')
@section('contenido')
<div class='seccion'>
@if ($solicitudes->isEmpty())
<p>No has enviado ninguna solicitud</p>
@else
    <h3>Solicitudes enviadas</h3>
    @foreach ($solicitudes as $solicitud)
    <div class='bloque-solicitud'>
        <div class='texto-solicitudes'>
            <p>Enviaste una solicitud a "{{$solicitud->publicacion->nombre_publicacion}}" </p>
        </div>
    </div>
@endforeach
    </div>
@endif
@endsection
