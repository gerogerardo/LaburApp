@extends('layouts.plantilla')
@section('titulo','Ver Publicación')
@section('contenido')
<h1>Ver publicación</h1>

<div class="seccion">
    <div class="publicaciones">
        <div class="link">
            <h2>{{ $publicacion->nombre_publicacion }}</h2>
            <p>{{ $publicacion->descripcion }}</p>
            <p>{{ $publicacion->profesion->nombre_profesion ?? 'Sin especificar' }}</p>
            <p>Publicado por: 
                <input type="button" class="boton" 
                    value="{{ $publicacion->usuario->nombre }} {{ $publicacion->usuario->apellido }}" 
                    onclick="location.href='{{ route('ver.usuario', $publicacion->id_publicaciones) }}'">
            </p>

            <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen de la publicación" id="fotopubli">

            <div style="margin-top: 15px;">
                <input type="button" class="boton" value="solicitar" onclick="location.href='{{ route('solicitar.publicacion', $publicacion->id_publicaciones) }}'" >
                <input type="button" class="boton" value="Volver" onclick="location.href='{{ route('buscar.publicaciones') }}'">
                
            </div>
        </div>
    </div>
</div>

<hr>

{{-- Mensajes de éxito/error --}}
@if(session('success'))
    <div class="alerta exito">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alerta error">{{ session('error') }}</div>
@endif

{{-- Formulario de Calificación --}}
@auth
    @if($publicacion->id_usuario !== Auth::id())
        <div class="seccion">
            <h3>Calificar esta publicación</h3>
            <form action="{{ route('ratings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_publicaciones" value="{{ $publicacion->id_publicaciones }}">

                <div class="campo">
                    <label for="rating">Calificación (1-5):</label>
                    <select name="rating" id="rating" required>
                        <option value="">Selecciona...</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                        @endfor
                    </select>
                </div>

                <div class="campo">
                    <label for="comentario">Comentario:</label> <br>
                    <textarea maxlength="80" name="comentario" id="comentario"></textarea>  
                </div>

                <input type="submit" class="boton" value="Enviar Calificación">
            </form>
        </div>
        <hr>
    @endif
@endauth

<div class="recuadro-promedio" style="background-color: #f0f8ff; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
    <strong>Opiniones de la publicacion</strong><br>
    @if($publicacion->ratings->count() > 0)
        {{ $publicacion->averageRating() }} ⭐ ({{ $publicacion->ratings->count() }} calificaciones)
    @else
        No hay calificaciones todavía.
    @endif
</div>

{{-- Lista de calificaciones --}}
<div class="seccion">
    <h3>Calificaciones</h3>
    @if($publicacion->ratings->count() > 0)
        <ul class="lista-calificaciones">
            @foreach($publicacion->ratings as $rating)
                <li class="item-calificacion {{ Auth::check() && $rating->id_usuario == Auth::id() ? 'mi-calificacion' : '' }}">
                    <strong>{{ $rating->user?->nombre }} {{ $rating->user?->apellido }}</strong>  
                        — {{ $rating->rating }} ⭐  
                    <br>
                    <em>{{ $rating->comentario }}</em>

                    @if(Auth::check() && $rating->id_usuario == Auth::id())
                        <form action="{{ route('ratings.destroy', $rating->id_rating) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="boton eliminar" value="Eliminar">
                        </form>
                    @endif
                </li>
            @endforeach

        </ul>
    @else
        <p>No hay calificaciones todavía.</p>
    @endif
</div>

@endsection