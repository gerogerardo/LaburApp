@extends('layouts.plantilla')
@section('titulo','Ver Publicación')
@section('contenido')

    <div class="publicaciones">
        <div class="link">
            <p><strong>Título:</strong> {{ $publicacion->nombre_publicacion }} <br>  </p>
            <p> <strong>Descripcion: </strong> {{ $publicacion->descripcion }} <br> </p>
            <p> <strong>Profesión: </strong> {{ $publicacion->profesion->nombre_profesion ?? 'Sin especificar' }} <br> </p>
            <p> <strong>Publicado por: </strong>
    @php
        $esMiPerfil = Auth::check() && Auth::id() === $publicacion->usuario->id_usuario;
    @endphp

    @if ($esMiPerfil)
        <input type="button" class="boton" 
            value="{{ $publicacion->usuario->nombre }} {{ $publicacion->usuario->apellido }}" 
            onclick="location.href='{{ route('perfil') }}'">
    @else
        <input type="button" class="boton" 
            value="{{ $publicacion->usuario->nombre }} {{ $publicacion->usuario->apellido }}" 
            onclick="location.href='{{ route('ver.perfilDeOtroUsuario', $publicacion->usuario->id_usuario) }}'">
    @endif
</p>


            <img src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Imagen de la publicación" id="fotopubli">

            <div style="margin-top: 15px;">
                <input type="button" class="boton" value="Solicitar" onclick="location.href='{{ route('solicitar.publicacion', $publicacion->id_publicaciones) }}'" >
                <input type="button" class="boton" value="Volver" onclick="location.href='{{ route('buscar.publicaciones') }}'">
                
            </div>
        </div>
    </div>


<hr>



@if (session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

<div class="link">
<!-- {{-- Formulario de Calificación --}} -->
@auth
    @if($publicacion->id_usuario !== Auth::id())
        <div >
            <h3>Calificar esta publicación</h3>
            <form action="{{ route('ratings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_publicaciones" value="{{ $publicacion->id_publicaciones }}">

                <div class="campo" style="padding-bottom: 2vh;">
                    <label for="rating">Calificación (1-5):</label>
                    <select name="rating" id="rating" required>
                        <option value="">Selecciona...</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                        @endfor
                    </select>
                </div>

                <div class="campo" style="padding-bottom: 2vh;">
                    <label for="comentario">Comentario:</label> <br>
                    <textarea maxlength="80" name="comentario" id="comentario"></textarea>  
                </div>

                <input type="submit" class="boton" value="Enviar Calificación">
            </form>
        </div>
        <hr>
    @endif
@endauth

<div>
    <div style="padding-bottom: 2vh;">
    <strong>Opiniones de la publicacion</strong><br>
    @if($publicacion->ratings->count() > 0)
        {{ $publicacion->averageRating() }} ⭐ ({{ $publicacion->ratings->count() }} calificaciones)
    @else
        No hay calificaciones todavía.
    @endif
</div>

<!-- {{-- Lista de calificaciones --}} -->

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
   </div>
@endsection