@extends('layouts.plantilla')
@section('titulo','Modificar Publicación')
@section('contenido')
<h1>Modificar publicación</h1>
<form action="{{ route('modificar.publicacion', $publicacion->id_publicaciones) }}" method="POST" enctype="multipart/form-data" class="cuadro-crear-formulario" >
    @csrf

    <label for="nombre_publicacion" class="label-modif-publi"><strong>Título</strong></label><br>
    <input class="titulo-publicacion select-modif-publi" type="text" name="nombre_publicacion" id="nombre_publicacion" value="{{ $publicacion->nombre_publicacion }}">
    <br>

    <label for="descripcion" class="label-modif-publi"><strong>Descripción</strong></label>
    <br>
    <textarea class="cuadro-crear-formulario select-modif-publi" name="descripcion" id="descripcion" cols="30" rows="10">{{ $publicacion->descripcion }}</textarea>
    <br>

    <label for="profesion" class="label-modif-publi"><strong>Profesión</strong></label><br>
    <select name="id_profesion" id="profesion" class="select-modif-publi">
        <option value="" selected disabled>Seleccionar Profesión</option>
        @foreach ($profesiones as $profesion)
            <option value="{{ $profesion->id_profesion }}" {{ $publicacion->id_profesion == $profesion->id_profesion ? 'selected' : '' }}>
                {{ $profesion->nombre_profesion }}
            </option>
        @endforeach
    </select>
    <br><br>
    <label for="foto" class="label-modif-publi"><strong>Foto</strong></label>
    <br>
    <div class="contenedor-foto-mod-publi">
    <img id="fotopubli" src="{{ asset('storage/' . $publicacion->foto_portada) }}" alt="Foto de la publicación" >
    </div>
    <br>
    <input type="file" name="foto_portada" accept="image/*">
    <br>

    <input type="submit" value="Modificar publicación" class="boton">
</form>
@endsection
