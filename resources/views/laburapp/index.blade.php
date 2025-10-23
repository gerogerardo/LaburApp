@extends('layouts.plantilla')
@section('titulo','Bienvenido a LABURAPP')


@if (session('success'))
    <div class="alertas">
        {{ session('success') }}
    </div>
@endif


    <div class="grupo">
    @section('contenido')
        <h1 class="titulo">BIENVENIDO A LABURAPP</h1>
        <form class="busqueda" action="{{route('buscar.publicaciones')}}" method="GET">
            <input class="cajaDeBusqueda" type="search" name="busq" class="caja" placeholder="Busqueda por palabra" required>
            <input class="btn-busqueda" type="submit" value="Enviar" class="boton" onclick="location.href='{{ route('buscar.publicaciones') }}'">
        </form>
    </div>
    <div class="seccion">
    <div class="publicaciones">
        @foreach($publicacionesTotales as $publicacion)
            <div class="link">
                <strong>Título:{{ $publicacion->nombre_publicacion }}</strong><br>
                Descripcion:{{ $publicacion->descripcion }}<br>
                Profesión: {{ $publicacion->profesion->nombre_profesion ?? 'Sin especificar' }} <br>
                Usuario: {{ $publicacion->usuario->nombre}} {{$publicacion->usuario->apellido}}<br>
                <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen de la publicación" width="150" id="fotopubli"><br>
                <input type="button" class="boton" value="Ver publicación" onclick="location.href='{{ route('ver.publicacion', $publicacion->id_publicaciones) }}'">
            </div>
            @endforeach
        </div>
            {{$publicacionesTotales->links('pagination::bootstrap-5') }}    
    </div>
    </main> 
    @endsection
    