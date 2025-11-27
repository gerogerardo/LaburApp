@extends('layouts.plantilla')
@section('titulo','Resultados de la busqueda')

@section('contenido')
<h1>Búsqueda</h1>
<form class="busqueda" action="{{route('buscar.publicaciones')}}" method="GET">
            <input class="cajaDeBusqueda" type="search" name="busq" class="caja" placeholder="Búsqueda por palabra" required>
            <input class="btn-busqueda" type="submit" value="Enviar" class="boton" onclick="location.href='{{ route('buscar.publicaciones') }}'">
        </form>
@if($usuarios->isEmpty())
        <h3 style="margin-top: 2dvh; margin-bottom: 2dvh;">Usuarios</h3><br>
        <p>No se encontraron usuarios</p>
@else
<div class="seccion">
        <div class="contenedor-busquedas">
        <h3 style="margin-top: 2dvh; margin-bottom: 2dvh;">Usuarios</h3>
        <div class="publicaciones">
                @foreach($usuarios as $usuario)
                <li class="link">
                        <strong>{{ $usuario->nombre }}</strong><br>
                        <img src ="{{asset ('storage/'.$usuario->foto_perfil) }}" alt="Foto de usuario" height="300" width="150" id="fotopubli"><br>
                </li>
                @endforeach
        </div>
</div>
<div>
        {{$usuarios->links('pagination::bootstrap-5') }}
</div>
        @endif
@if($publicaciones->isEmpty())
        <h3 style="margin-top: 2dvh; margin-bottom: 2dvh;">Publicaciones</h3><br>
        <p>No se encontraron publicaciones que coincidan con tu búsqueda.</p>
@else
<h3 style="margin-top: 2dvh; margin-bottom: 2dvh;">Publicaciones</h3>
<div class="publicaciones">
@foreach($publicaciones as $publicacion)
<li class="link">
        <strong>Título:{{ $publicacion->nombre_publicacion }}</strong><br>
        Descripcion:{{ $publicacion->descripcion }}<br>
        Profesión: {{ $publicacion->profesion->nombre_profesion ?? 'Sin especificar' }} <br>
        Usuario: {{ $publicacion->usuario->nombre}} {{$publicacion->usuario->apellido}}<br>
        <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen de la publicación" width="150" id="fotopubli"><br>
        <input type="button" class="boton" value="Ver publicación" onclick="location.href='{{ route('ver.publicacion', $publicacion->id_publicaciones) }}'">
</li>
@endforeach
</div>
        <div>
        {{$publicaciones->links('pagination::bootstrap-5') }}
        </div>
@endif
@endsection