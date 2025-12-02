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

    @foreach ($solicitudes as $solicitud)
    
    <div class='bloque-solicitud'>
        <a href="{{ route('ver.perfilDeOtroUsuario', $solicitud->usuario->id_usuario) }}" style="text-decoration: none; color: inherit;">
        <div class='texto-solicitudes'>
            <p>Tienes una solicitud de <strong>{{$solicitud->usuario->nombre}} {{$solicitud->usuario->apellido}}</strong> para la publicacion de <strong> "{{ $solicitud->publicacion->nombre_publicacion }}"</strong>
            <br><br>
            Solicitado el día: <strong>{{$solicitud->created_at ? $solicitud->created_at->format('d/m/Y') : 'Sin fecha'}} </strong> </p>
        </div>
        </a>
    </div>
@endforeach
    </div>

    @endif
    @endsection
