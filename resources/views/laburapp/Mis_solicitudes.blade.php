@extends('layouts.plantilla')
@section('titulo','Solicitudes')
@section('contenido')
<div class='seccion'>
@if ($solicitudes->isEmpty())
<p>no has enviado ninguna solicitud</p>
@else
    <p>mis solicitudes</p>
    @foreach ($solicitudes as $solicitud)
    <div class='bloque-solicitud'>
        <div class='texto-solicitudes'>
            <p>Enviaste una solicitud a "{{ $solicitud->publicacion->nombre_publicacion }}" </p>
        </div>
    </div>
@endforeach
    </div>
@endif
@endsection
