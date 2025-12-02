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
        <a href="{{ route('ver.perfilDeOtroUsuario', $solicitud->publicacion->usuario->id_usuario) }}" style="text-decoration: none; color: inherit;">
        <div class='texto-solicitudes'>
            <p>Enviaste una solicitud a la publicación "<strong>{{$solicitud->publicacion->nombre_publicacion}}</strong>" del usuario <strong> {{$solicitud->publicacion->usuario->nombre}} {{$solicitud->publicacion->usuario->apellido}}</strong><br><br> Solicitado el día: <strong>{{$solicitud->created_at ? $solicitud->created_at->format('d/m/Y') : 'Sin fecha'}}</strong></p>
        </div>
    </a>
    </div>
@endforeach
    </div> 
@endif
@endsection


