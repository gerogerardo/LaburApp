@extends('layouts.plantilla')
@section('titulo','Resultados de la busqueda')

@section('contenido')
<h1>Búsqueda</h1>
<form class="busqueda" action="{{route('buscar.publicaciones')}}" method="GET">
            <input class="cajaDeBusqueda" type="search" name="busq" class="caja" placeholder="Búsqueda por palabra" required>
            <input class="btn-busqueda" type="submit" value="Enviar" class="boton" onclick="location.href='{{ route('buscar.publicaciones') }}'">
        </form>
@if($usuarios->isEmpty())
        <div class="contenedor-busquedas" style="margin-bottom: 4dvh; margin-top: 4dvh;">
                <h3 style="margin-top: 2dvh; margin-bottom: 2dvh;">Usuarios</h3><br>
                <p class="link" style="font-weight: 450;">No se encontraron usuarios</p>
        </div> 
@else
<div class="seccion">
        <div class="contenedor-busquedas">
        <h3 style="margin-top: 2dvh; margin-bottom: 2dvh;">Usuarios</h3>
        <div class="publicaciones">
                @foreach($usuarios as $usuario)
                <a class="publi-link" href='{{ route('ver.perfilDeOtroUsuario', $usuario->id_usuario) }}' style="text-decoration: none;">
                        <li class="link">
                                <strong>{{ $usuario->nombre }}</strong><br>
                                <img src ="{{asset ('storage/'.$usuario->foto_perfil) }}" alt="Foto de usuario" height="300" width="150" id="fotopubli"><br>
                        </li>
                </a>
                @endforeach
        </div>
</div>
<div>
        {{$usuarios->links('pagination::bootstrap-5') }}
</div>
        @endif
@if($publicaciones->isEmpty())
        <div class="contenedor-busquedas">
                <h3 style="margin-top: 4dvh; margin-bottom: 4dvh; border-top: 1px solid #505050af; padding-top: 6dvh; width: 100%; text-align: center;">Publicaciones</h3><br>
                <p class="link" style="font-weight: 450; margin-bottom: 4dvh;">No se encontraron publicaciones que coincidan con tu búsqueda.</p>
        </div>
@else
<h3 style="margin-top: 4dvh; margin-bottom: 2dvh; border-top: 1px solid #505050af; padding-top: 3dvh; width: 100%; text-align: center;">Publicaciones</h3>
<div class="publicaciones">
@foreach($publicaciones as $publicacion)
<a class="publi-link link" href="{{ route('ver.publicacion', $publicacion->id_publicaciones) }}" style="text-decoration: none;">

                <p><strong>Título:</strong> {{ $publicacion->nombre_publicacion }}</p>
                <p><strong>Descripcion:</strong> {{ $publicacion->descripcion }}</p>
                <p><strong>Profesión:</strong> {{ $publicacion->profesion->nombre_profesion ?? 'Sin especificar' }}</p>
                <p><strong>Usuario:</strong> {{ $publicacion->usuario->nombre}} {{$publicacion->usuario->apellido}}</p>
                <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen de la publicación" width="150" id="fotopubli"><br>
                <input type="button" class="boton" value="Ver publicación" onclick="location.href='{{ route('ver.publicacion', $publicacion->id_publicaciones) }}'">

</a>
@endforeach
</div>
        <div>
        {{$publicaciones->links('pagination::bootstrap-5') }}
        </div>
@endif
@endsection