@extends('layouts.plantilla') 
@section('titulo', 'Mis Publicaciones')
@section('contenido')
<div class="seccion">
    <h1>Mis publicaciones</h1>
    <div class="link">
        <input type="button" class="boton" value="Crear publicación" onClick='location="{{ route('formulario.publicacion') }}"'>
    </div>
    @if ($publicaciones->isEmpty())
        <div class="link">
        <p style="font-size: large;">No tenés publicaciones todavía.</p>
        </div>
        </div>
    @else
        <div class="seccion">
            <div class="publicaciones">
                @foreach ($publicaciones as $publicacion)
                    <div class="link">
                        <h2>{{ $publicacion->nombre_publicacion }}</h2>
                        <p>{{ $publicacion->descripcion }}</p>
                        <p>{{ $publicacion->profesion->nombre_profesion ?? 'Sin profesión' }}</p>
                        
                        <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen" id="fotopubli-index">
                        <div class="botones-mis-publis">
                            <input type="button" class="boton" 
                                value="Modificar publicación" 
                                onclick="location.href='{{ route('formulario.modificar.publicacion', $publicacion->id_publicaciones) }}'">

                            <form action="{{ route('eliminar.publicacion', $publicacion->id_publicaciones) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar la publicación?')">
                                @csrf
                                <button type="submit" class="boton eliminar">Eliminar publicación</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
        {{ $publicaciones->links('pagination::bootstrap-5') }}

        </div>
    @endif
@endsection
