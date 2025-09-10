@extends('layouts.plantilla') 
@section('titulo', 'Mis Publicaciones')
@section('contenido')
<div class="seccion">
    <h1>Mis publicaciones</h1>

    @if ($publicaciones->isEmpty())
        <p>No tenés publicaciones todavía.</p>
        </div>
    @else
        <div class="seccion">
            <div class="publicaciones">
                @foreach ($publicaciones as $publicacion)
                    <div class="link">
                        <h2>{{ $publicacion->nombre_publicacion }}</h2>
                        <p>{{ $publicacion->descripcion }}</p>
                        <p>{{ $publicacion->profesion->nombre_profesion ?? 'Sin profesión' }}</p>
                        
                        <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen" id="fotopubli">
                        
                        <input type="button" class="boton" 
                            value="Modificar publicación" 
                            onclick="location.href='{{ route('formulario.modificar.publicacion', $publicacion->id_publicaciones) }}'">

                        <form action="{{ route('eliminar.publicacion', $publicacion->id_publicaciones) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar la publicación?')">
                            @csrf
                            <button type="submit" class="boton">Eliminar publicación</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
        {{ $publicaciones->links('pagination::bootstrap-5') }}

        </div>
    @endif
@endsection
