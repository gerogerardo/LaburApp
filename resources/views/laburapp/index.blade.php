@extends('layouts.plantilla')
@section('titulo','Bienvenido a LABURAPP')


@if (session('success'))
    <div class="alertas-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alertas-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="grupo">
    @section('contenido')
        <h1 class="titulo">BIENVENIDO A LABURAPP</h1>
        <form class="busqueda" action="{{route('buscar.publicaciones')}}" method="GET">
            <input class="cajaDeBusqueda" type="search" name="busq" class="caja" placeholder="Búsqueda por palabra" required>
            <input class="btn-busqueda" type="submit" value="Enviar" class="boton" onclick="location.href='{{ route('buscar.publicaciones') }}'" style="color: white;">
        </form>
    </div>
    <div class="seccion">
    <div class="publicaciones">
        @foreach($publicacionesTotales as $publicacion)
        <a class="publi-link link" href="{{ route('ver.publicacion', $publicacion->id_publicaciones) }}" style="text-decoration: none;">
                    <p><strong>Título:</strong> {{ $publicacion->nombre_publicacion }} <br>  </p>
                    <p> <strong>Descripcion: </strong> {{ $publicacion->descripcion }} <br> </p>
                    <p> <strong>Profesión: </strong> {{ $publicacion->profesion->nombre_profesion ?? 'Sin especificar' }} <br> </p>
                    <p> <strong>Usuario: </strong>{{ $publicacion->usuario->nombre}} {{$publicacion->usuario->apellido}}<br> </p>
                    <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen de la publicación" width="150" id="fotopubli-index"><br>
                    <input type="button" class="boton" value="Ver publicación" onclick="location.href='{{ route('ver.publicacion', $publicacion->id_publicaciones) }}'"> 
            </a>
            @endforeach
              
            
        </div>
        <div>
            {{$publicacionesTotales->links('pagination::bootstrap-5') }}    
    </div>
    </main> 
    @endsection
    