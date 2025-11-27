@extends('layouts.plantilla')
@section('titulo', 'Modificar Usuario') 
@section('contenido')

<main class="centrar">
    <div class="cuadro-modificar-perfil">
        <h1>Modificar Usuario</h1>
        
        <form action="{{ route('actualizar.usuario') }}" method="POST" enctype="multipart/form-data"  onsubmit="return  verificar()" class="form-modif-perfil"> 
            @csrf

            <!-- FOTO DE PERFIL -->
            <div class="contenedor-input div1">
                <label for="foto_perfil_modif"><strong>Foto de Perfil:</strong></label> <br>
                @if(Auth::user()->foto_perfil)
                    <img id="imagenPreview" src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" class="fotoperfil" >
                @else
                    <img id="imagenPreview" src="{{ asset('images/icono_usuario.png') }}" class="fotoperfil" width="150">
                @endif
                <input type="file" name="foto_perfil" id="foto_perfil" onchange="previewImage(event)">
            </div>

            <!-- NOMBRE Y APELLIDO -->
            <div class="contenedor-input div2">
                <h3>Nombre</h3>
                <input type="text" name="nombre" value="{{ auth()->user()->nombre }}">
            </div>

            <div class="contenedor-input div3">
                <h3>Apellido</h3>
                <input type="text" name="apellido" value="{{ auth()->user()->apellido }}">
            </div>

            <!-- CONTRASEÑA -->
            <div class="contenedor-input div4">
                <h3>Nueva Contraseña</h3>
                <input type="password" name="nueva-contraseña" id="pass" name="pass">
                            <p class="eye">
            <img src="{{ asset('/storage/imagenes/ojo-cerrado.png') }}" alt="Mostrar contraseña">
            </p>
            </div>

            <!-- MAIL -->
            <div class="contenedor-input div5">
                <h3>Mail</h3>
                <input type="email" name="mail" value="{{ auth()->user()->mail }}">
            </div>

            <!-- INFORMACIÓN -->
            <div class="contenedor-input div6">
                <h3>Información</h3>
                <textarea id="info-input" name="informacion">{{ auth()->user()->informacion }}</textarea>
            </div>

            <!-- TELÉFONO -->
            <div class="contenedor-input div7">
                <h3>Teléfono</h3>
                <input type="tel" name="telefono" value="{{ auth()->user()->telefono }}">
            </div>

            <!-- DOMICILIO -->
            <div class="contenedor-input div8">
                <h3>Domicilio</h3>
                <input type="text" name="domicilio" value="{{ auth()->user()->domicilio }}">
            </div>


            <!-- LOCALIDAD -->
            <div class="contenedor-input div9">
                <h3>Localidad</h3>
                <select name="id_localidad" required>
                    @foreach ($localidades as $localidad)
                        <option value="{{ $localidad->id_localidad }}"
                            {{ $usuario->id_localidad == $localidad->id_localidad ? 'selected' : '' }}>
                            {{ $localidad->nombre_localidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- BOTONES -->
            <div class="centrar-boton div10">
                <input type="submit" value="Actualizar perfil" class="boton">
                <input type="button" value="Volver" class="boton" onclick="location='{{ route('perfil') }}'">
            </div>
        </form>

        <!-- BOTÓN ELIMINAR -->
        <form action="{{ route('eliminar.usuario') }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar tu cuenta?')">
            @csrf
            <button type="submit" class="boton">Eliminar cuenta</button>
        </form>
    </div>
</main>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('imagenPreview').src = e.target.result;
        reader.readAsDataURL(file);
    }
}
</script>
@endsection



