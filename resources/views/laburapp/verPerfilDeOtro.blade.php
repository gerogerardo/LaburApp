@extends('layouts.plantilla')
@section("titulo", "Perfil de Usuario")

@section('contenido')

<main>
    <div class='barra-arriba'>
    
    @auth
        
        <div class='bloque-perfil'>
            <img src="{{ asset('storage/' . $usuario->foto_perfil ) }}" class='fotoperfil'>
        </div>
        <div class='info'>
            <div class='contenedor-datos'><h2>Nombre</h2><p>{{ $usuario->nombre }} {{ $usuario->apellido }}</p></div>
            <div class='contenedor-datos'><h2>Información</h2> <p>{{ $usuario->informacion }}</p></div>
            <div class='contenedor-datos'> <h4>Número de Teléfono:</h4><p>{{ $usuario->telefono }}</p></div>
            <div class='contenedor-datos'> <h4>Domicilio</h4> <p>{{ $usuario->domicilio }}</p></div>
            <div class='contenedor-datos'> <h4>Mail</h4> <p>{{ $usuario->mail }}</p></div>
            <div class='contenedor-datos'> <h4>Localidad</h4> <p>{{ $usuario->localidad->nombre_localidad }}</p></div>
            
            @if($promedioGeneral > 0)
                <p><h4>Promedio general:</h4>{{ number_format($promedioGeneral, 1)  }} / 5 ⭐</p>
            @else
                <p><h4>Promedio general:</h4> Aún no tiene calificaciones.</p>
            @endif
            <div class='contenedor-datos'>
                <h4>Promedio por profesión:</h4>
        
                @if ($promedioPorProfesion->isNotEmpty())
                    <ul>
                        @foreach ($promedioPorProfesion as $dato)
                            <li>{{ $dato->profesion }} → {{ number_format($dato->promedio, 1) }} / 5 ⭐</li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay calificaciones por profesión aún.</p>
                @endif
            </div>
        </div>
    </div>


    @endauth
    @guest
    <div class='contenedor-no-sesion'>
        <a href="{{ route('inicioSesion.form') }}" style="text-decoration: none; color: black; padding: 3dvh;">No hay usuario logueado, <strong>Inicia Sesión.</strong></a>
    </div>
    @endguest
    

</main>
    
@endsection