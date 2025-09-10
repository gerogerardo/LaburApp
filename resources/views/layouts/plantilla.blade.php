
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="storage/imagenes/logo.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <title>@yield('titulo')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trabajos y emprendimientos">
    <meta name="keywords" content="Trabajo, empleo, rubro, emprendimiento, laburo">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
<header>
    <img id="abrir" class="abrir-menu" src="./imagenes/fotoMenu.png" alt="Menú hamburguesa">
        <img class="logo" src="storage/imagenes/logo.png" alt="Logo de Laburapp">
        <nav class="nav-bar" id="nav">
            <button id="cerrar" class="cerrar-menu">X</button>
                    <ul class="nav-list"> 
                    <li><a href="{{  route('index')}}" alt="indice">Principal</a></li>
                    <li><a href="{{ route ('perfil')}}" alt="Ver Perfil">Ver Perfil</a></li>
                    <li><a href="{{  route('misPublicaciones')}}" alt="Ver publicaciones"> Mis publicaciones</a></li>
                    </ul>
            </nav>
            <div class="perfil"> 
                    @auth
                    <div class="usuario">
                    <p>Bienvenido, {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
                    <a class="btn-cerrar-sesion" href="{{ route('cerrarSesion.usuario') }}" alt="CERRAR SESIÓN">Cerrar sesión</a>
                    </div>
                    <img src="{{ asset('storage/' . auth()->user()->foto_perfil )}}" alt="Foto de perfil" width="33%">
                    @else
                    <a class="btn-busqueda" href="{{ route('inicioSesion.form') }}">Iniciar sesión</a>
                    <p>No hay usuario logueado.</p>
                    @endauth     
        </div>
    </header>
    <main class="cabeceraindex">
            <style>
    .page-item.active .page-link {
        background-color: #333;
        border-color: #333;
        color: #f1dabf;
    }
    .page-link {
    color: #333;
    background-color: #fff;
    border-color: #333;
}
</style>
        @yield('contenido')
    </main> 
    <footer> 
        <h3 id="derecho"></h3>
        <a target="_blank" href="https://www.whatsapp.com/?lang=es_LA"><img class="btn-wsp" src="storage/imagenes/wsp.png" alt="Logo de wsp"> </a>
        <script src="{{  asset('js/script.js')}}"></script>
    </footer>