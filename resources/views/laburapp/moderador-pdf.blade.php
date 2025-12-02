<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Moderación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .card {
            border: 1px solid #ddd;
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
        }
        .card-header {
            background: #007bff;
            color: white;
            padding: 10px;
            margin: -15px -15px 10px -15px;
            border-radius: 5px 5px 0 0;
        }
        .card-header.success {
            background: #28a745;
        }
        h4 {
            margin: 0 0 15px 0;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Reporte de Moderación</h1>
    <p style="text-align: center; color: #666; font-size: 16px;">{{ $mesNombre }}</p>

    <!-- PUBLICACIONES -->
    <div class="card">
        <div class="card-header">
            Publicaciones creadas en {{ $mesNombre }}
        </div>
        <div>
            <h4>Total: {{ $publicacionesTotales }}</h4>
            <h5>Por profesión:</h5>
            @if($publicacionesPorProfesion->count() > 0)
                <ul>
                    @foreach($publicacionesPorProfesion as $profesion => $cantidad)
                        <li>
                            <span>{{ $profesion }}</span>
                            <span class="fw-bold">{{ $cantidad }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No hay publicaciones para este mes.</p>
            @endif
        </div>
    </div>

    <!-- SOLICITUDES -->
    <div class="card">
        <div class="card-header success">
            Solicitudes realizadas en {{ $mesNombre }}
        </div>
        <div>
            <h4>Total: {{ $solicitudesTotales }}</h4>
            <h5>Por profesión:</h5>
            @if($solicitudesPorProfesion->count() > 0)
                <ul>
                    @foreach($solicitudesPorProfesion as $profesion => $cantidad)
                        <li>
                            <span>{{ $profesion }}</span>
                            <span class="fw-bold">{{ $cantidad }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No hay solicitudes para este mes.</p>
            @endif
        </div>
    </div>

    <hr>


@if(!empty($imgPublicaciones))
    <img src="{{ $imgPublicaciones }}" style="width: 100%; max-width: 600px;">
@endif


@if(!empty($imgSolicitudes))
    <img src="{{ $imgSolicitudes }}" style="width: 100%; max-width: 600px;">
@endif

    
</body>
</html> 