<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <title>Inicio de sesión</title>
    <meta name="description" content="Trabajos y emprendimientos">
    <meta name="keywords" content="Trabajo, empleo, rubro, emprendimiento, laburo">
    <script src="{{  asset('js/script.js')}}"></script>
</head>
<body>
@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif
    <header class="texto-inicio-sesion">
        <h1>Inicio de Sesión</h1>
    </header>
    <main>
        <div class="centrar">
            <form name="logueo" method="post" action="{{ route('inicioSesion.usuario') }}" class="cuadro-inicio-sesion">
                @csrf
                @if($errors->has('inicioSesion'))
                    <div class="error">{{ $errors->first('inicioSesion') }}</div>
                @endif
                <div class="contenedor-input">
                    <h3>Email</h3> <br>
                    <input type="email" placeholder="Ingrese su Correo Electrónico..." name="mail" required autofocus>
                </div>
                <br> <br>
                <div class='contenedor-input'>
                    <h3>Contraseña</h3> <br>
                    <div class="input-row">
                        <input id="pass" type="password" placeholder="Ingrese su Contraseña..." name="pass" required>
                        <p class="eye">
                            <img src="{{ asset('/storage/imagenes/ojo-cerrado.png') }}" alt="Mostrar contraseña">
                        </p>
                    </div>
                </div>
                <br> <br>
                <input class="btn-busqueda" type="submit" value="Iniciar Sesión">
                <br> <br>
                <a href="{{ url('registroUsuario') }}"><h4>¿No tenés cuenta? REGISTRATE ACÁ</h4></a> 
                <a href="{{ route('index') }}"><h4>Volver</h4></a>
            </form>
        </div>
    </main> 
    <footer> 
        <h3 id="derecho"></h3>
        <a target="_blank" href="https://www.whatsapp.com/?lang=es_LA"><img class="btn-wsp" src="{{ asset('/storage/imagenes/wsp.png') }}" alt="Logo de wsp"> </a>
    </footer>
</body>
</html>