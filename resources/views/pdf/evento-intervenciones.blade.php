<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Impacto con Fauna {{ $reporte->codigo }}</title>
    <style>
        @page {
            margin: 0.5in;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0.5in;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            background-color: #004080;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            page-break-after: avoid;
        }

        .content {
            margin-top: 20px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
            page-break-after: avoid;
        }

        table.section-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
            page-break-inside: auto;
            table-layout: auto;
        }

        .section-table th,
        .section-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .section-table td:nth-child(1) {
            width: 40%;
        }

        .section-table td:nth-child(2) {
            width: 60%;
        }

        .section-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .page-break {
            page-break-before: always;
        }

        div, p, td {
            page-break-inside: auto;
        }

        /* Estilos específicos para tabla de municiones */
        .municiones-table {
            table-layout: fixed; /* Fuerza el ancho fijo de las columnas */
        }

        .municiones-table th,
        .municiones-table td {
            text-align: center;
            white-space: nowrap; /* Evita que el texto se rompa en líneas múltiples */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .municiones-table thead tr th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Anchos específicos para columnas de municiones */
        .municiones-table th:nth-child(1),
        .municiones-table td:nth-child(1) {
            width: 50%; /* Nombre */
        }

        .municiones-table th:nth-child(2),
        .municiones-table td:nth-child(2) {
            width: 30%; /* Acción */
        }

        .municiones-table th:nth-child(3),
        .municiones-table td:nth-child(3) {
            width: 20%; /* Cantidad */
        }

        /* Alternativa: Si quieres que el texto se ajuste pero manteniendo el layout */
        .municiones-table-alt th,
        .municiones-table-alt td {
            text-align: center;
            white-space: normal; /* Permite salto de línea natural */
            word-wrap: break-word;
            hyphens: auto;
        }

        .municiones-table-alt th:nth-child(1),
        .municiones-table-alt td:nth-child(1) {
            width: 45%;
        }

        .municiones-table-alt th:nth-child(2),
        .municiones-table-alt td:nth-child(2) {
            width: 35%;
        }

        .municiones-table-alt th:nth-child(3),
        .municiones-table-alt td:nth-child(3) {
            width: 20%;
            min-width: 80px; /* Ancho mínimo para evitar texto vertical */
        }

        /* Estilos específicos para tabla de actualizaciones */
        .actualizaciones-table {
            table-layout: fixed;
        }

        .actualizaciones-table th,
        .actualizaciones-table td {
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        .actualizaciones-table th:nth-child(1),
        .actualizaciones-table td:nth-child(1) {
            width: 15%; /* Fecha */
        }

        .actualizaciones-table th:nth-child(2),
        .actualizaciones-table td:nth-child(2) {
            width: 20%; /* Autor */
        }

        .actualizaciones-table th:nth-child(3),
        .actualizaciones-table td:nth-child(3) {
            width: 65%; /* Actualización - más ancho */
        }

        .actualizaciones-table thead tr th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    {{-- Encabezado --}}
    <div class="header">
        Tocumen S.A <br>
        {{ $reporte->user->aerodromo->nombre ?? 'N/A' }} <br>
        Reporte de Impacto con Fauna: {{ $reporte->id }}
    </div>

    <div class="content">

        {{-- Sección: Eventos --}}
        <div class="section-title">Eventos - Intervenciones</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Tipo de Evento:</td>
                    <td>{{ $reporte->tipo_evento ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Origen del Reporte:</td>
                    <td>{{ $reporte->origen ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Clima --}}
        <div class="section-title">Datos de Ubicación y Clima</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Coordenada X:</td>
                    <td>{{ $reporte->coordenada_x }}</td>
                </tr>
                <tr>
                    <td>Coordenada Y:</td>
                    <td>{{ $reporte->coordenada_y }}</td>
                </tr>
                <tr>
                    <td>Temperatura:</td>
                    <td>{{ $reporte->temperatura }} °C</td>
                </tr>
                <tr>
                    <td>Viento:</td>
                    <td>{{ $reporte->viento }} m/s</td>
                </tr>
                <tr>
                    <td>Humedad:</td>
                    <td>{{ $reporte->humedad }} %</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Fauna --}}
        <div class="section-title">Fauna Involucrada</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Grupo de Fauna:</td>
                    <td>{{ $reporte->especie->grupo->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Nombre de la Especie:</td>
                    <td>{{ $reporte->especie->nombre_cientifico ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Atractivo para la Fauna:</td>
                    <td>{{ $reporte->atractivo->nombre }}</td>
                </tr>
                <tr>
                    <td>Cantidad Vista:</td>
                    <td>{{ $reporte->vistos }}</td>
                </tr>
                <tr>
                    <td>Cantidad Dispersados:</td>
                    <td>{{ $reporte->dispersados }}</td>
                </tr>
                <tr>
                    <td>Cantidad:</td>
                    <td>{{ $reporte->sacrificados }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Munición Utilizada - VERSIÓN CORREGIDA --}}
        @if($reporte->pivoteEvento->isNotEmpty())
            <div class="section-title">Equipo/Munición Utilizada</div>
            <table class="section-table municiones-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acción</th>
                        <th>Cant.</th> {{-- Texto más corto para evitar problemas --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporte->pivoteEvento as $item)
                        <tr>
                            <td>{{ $item->catalogoInventario->nombre ?? 'Sin nombre' }}</td>
                            <td>{{ $item->acciones->nombre ?? 'Sin acción' }}</td>
                            <td>{{ $item->cantidad_utilizada }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No se usaron municiones ni equipos en esta intervención.</p>
        @endif

        {{-- Comentarios --}}
        <div class="section-title">Comentarios</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Comentarios:</td>
                    <td>{{ $reporte->comentarios }}</td>
                </tr>
            </tbody>
        </table>
    {{-- ACTUALIZACIONES --}}
    @if($reporte->actualizacionesEvento->isNotEmpty())
    <div class="section-title">Actualizaciones del Reporte</div>
    <table class="section-table actualizaciones-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Autor</th>
                <th>Actualización</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporte->actualizacionesEvento as $actualizacion)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($actualizacion->created_at)->timezone('America/Panama')->format('d/m/Y h:i A') }}</td>
                    <td>{{ $actualizacion->user->name ?? 'N/A' }}</td>
                    <td>{{ $actualizacion->actualizacion ?? 'Sin contenido' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No hay actualizaciones para este reporte.</p>
@endif
</body>
</html>
