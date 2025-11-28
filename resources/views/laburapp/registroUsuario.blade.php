
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{  asset('js/script.js')}}"></script>
    <title>Registro de usuario</title>
</head>

<body>
    <header class="texto-inicio-sesion">
        <h1> Registro de Usuario </h1>
    </header>
    <main> 
        <div class="centrar">
            <form class="cuadro-registro-usuario" onsubmit="return  verificar()" method="POST" action="{{ route('registro.guardar') }}" enctype="multipart/form-data">
            @csrf
            <div class="caja-registro1">
                <div class='contenedor-input'>
                    <h3>Foto de perfil</h3><input type="file" name="imagen" >
                    @error('imagen')
                    <div class="alert alert-danger mt-2" style="color: #c70d0d;"><p>La imagen no debe ser mayor a 2MB</p></div>
                    @enderror
                </div>
            </div>
            <div class="caja-registro2">
                <div class='contenedor-input'>
                    <h3>Nombre</h3> <input type="text" placeholder="Ingrese su Nombre..." name="nombre" id="nombre"  required autofocus>
                </div>
                <div class='contenedor-input'>
                    <h3>Apellido</h3> <input type="text" placeholder="Ingrese su Apellido..." name="apellido" required autofocus> 
                </div>
                <div class='contenedor-input'>
                    <h3>Contraseña</h3> <input type="password" placeholder="Ingrese su Contraseña..." name="pass" id="pass" required  > 
                    <p class="eye">
                        <img src="{{ asset('/storage/imagenes/ojo-cerrado.png')}}" alt="Ojo cerrado">
                    </p>
                </div>
            </div>
            <div class="caja-registro3">
                <div class='contenedor-input'>
                    <h3>Correo Electrónico</h3> <input type="email" placeholder="Ingrese su Correo Electrónico..." id="mail" name="mail" minlength="11" required> 
                </div>
                <div class='contenedor-input'>
                    <h3>Teléfono o Celular</h3> <input type="tel" placeholder="Ingrese su Número de Teléfono..." name="telefono" required> 
                </div>
                <div class='contenedor-input'>
                    <h3>Seleccionar localidad</h3> 
                <select name="localidad" required>    
                <option value="" selected disabled>Seleccionar Localidad</option>
                @foreach ($localidades as $localidad)
                    <option value="{{ $localidad->id_localidad }}">{{ $localidad->nombre_localidad }}</option>
                @endforeach
                </select>   
                </div>
            </div>
            <div class="caja-registro4">
                <input class="btn-busqueda" type="submit" value="Crear usuario">
                <br>
                <a href="{{ url('index') }}"><h4>Volver al inicio</h4></a>
            </div>
            </form>
        </div>
    <main>
    <footer>
        <h3 id="derecho"></h3>
        <a target="_blank" href="https://www.whatsapp.com/?lang=es_LA"><img class="btn-wsp" src="storage/imagenes/wsp.png" alt="Logo de wsp"> </a>
    </footer>
</body>
</html>