@extends('layouts.plantilla')
@section('titulo','Solicitudes')
@section('contenido')
<div class='seccion'>
@if ($solicitudes->isEmpty())
<h1>Solicitudes enviadas</h1>
<div class="link">
    <p style="font-size: large;">No has enviado ninguna solicitud</p>
</div>
@else
    <h3>Solicitudes enviadas</h3>
    @foreach ($solicitudes as $solicitud)
    <div class='bloque-solicitud'>
        <div class='texto-solicitudes'>
            <p>Enviaste una solicitud a "<strong>{{$solicitud->publicacion->nombre_publicacion}}</strong>" </p>
        </div>
    </div>
@endforeach
    </div> 
@endif
@endsection


