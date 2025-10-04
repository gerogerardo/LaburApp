@extends('layouts.plantilla')
@section('titulo','Solicitudes')
@section('contenido')
<div class='seccion'>

  @foreach ($solicitudes as $solicitud)
  
    <div class='bloque-solicitud'>
        <div class='texto-solicitudes'>
            Tienes una solicitud de {{$solicitud->usuario->nombre}} {{$solicitud->usuario->apellido}}
            
            para la publicacion de <b>{{ $solicitud->publicacion->nombre_publicacion }}</b>
</div>
    </div>
@endforeach
    </div>
    @endsection
