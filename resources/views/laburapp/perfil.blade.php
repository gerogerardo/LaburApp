    @extends('layouts.plantilla')
    @section("titulo", "Perfil")

@section('contenido')

<main>
    <div class='barra-arriba'>
    
    @auth
    <div class='bloque-perfil'>
        <img src={{ asset('storage/' . auth()->user()->foto_perfil )}} class='fotoperfil'>
        <input class='boton' type='button' value='Modificar perfil' onClick='location="{{ route('formulario.modificar') }}"'>
        <input class='boton' type='button' value='Ver solicitudes' onClick='location="{{ route('ver.solicitudes') }}"' >
        <input type="button" class="boton" value="Crear publicación" onClick='location="{{ route('formulario.publicacion') }}"'>
    </div>

    <div class='info' >
        <div class='contenedor-datos'><h2>Nombre</h2><p>{{  auth()->user()->nombre }} {{  auth()->user()->apellido}}</></p> </div>
        <div class='contenedor-datos'><h2>Información</h2> <p>{{auth()->user()->informacion}}</p></div>
        <div class='contenedor-datos'> <h4>Número de Teléfono:</h4><p>{{auth()->user()->telefono}}</p></div>
        <div class='contenedor-datos'> <h4>Domicilio</h4> <p>{{ auth()->user()->domicilio }}</p></div>
        <div class='contenedor-datos'> <h4>Mail</h4> <p>{{ auth()->user()->mail }}</p></div>
        <div class='contenedor-datos'> <h4>Localidad</h4> <p>{{ auth()->user()->localidad->nombre_localidad }}</p></div>
        <h3>Promedio de calificaciones: 
    {{-- @if(is_numeric($promedio))
        {{ number_format($promedio, 1) }} ⭐
    @else
        {{ $promedio }}
    @endif --}}
</h3>
    
    </div>
</div>
    
    @endauth
    @guest
        </div>
        <div class="contenedor-no-sesion">
            <p>No tienes una cuenta ingresada. Inicia Sesión e inténtalo de nuevo.</p>
        </div>
    @endguest
    

</main>
    
    
@endsection
