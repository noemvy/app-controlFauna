<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Impacto con Fauna {{ $reporte->codigo }}</title>
    <style>
        /* Estilos generales de la página */
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

        /* Estilos del encabezado */
        .header {
            background-color: #004080;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            page-break-after: avoid;
        }

        /* Estilos del contenedor principal de contenido */
        .content {
            margin-top: 20px;
        }

        /* Estilos de las tablas de sección */
        table.section-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
            page-break-inside: auto;
            table-layout: auto;
        }

        /* Estilos de las celdas de encabezado y datos de las tablas de sección */
        .section-table th,
        .section-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* Define anchos relativos para las columnas 'Campo' y 'Dato' */
        .section-table td:nth-child(1) {
            width: 40%;
        }

        .section-table td:nth-child(2) {
            width: 60%;
        }

        /* Estilos para los títulos de sección */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
            page-break-after: avoid;
        }

        /* Reglas de salto de página */
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

        /* Estilos para el bloque de observaciones */
        .observations-block {
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 20px;
        }

        .observations-block strong {
            display: block;
            margin-bottom: 5px;
        }

        .observations-block p {
            margin: 0;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>

    {{-- Encabezado --}}
    <div class="header">
        Tocumen S.A <br>
        {{ $reporte->aerodromo->nombre ?? 'N/A' }} <br>
        Reporte de Impacto con Fauna: {{ $reporte->codigo }}
    </div>

    <div class="content">

        {{-- Sección: Generalidades --}}
        <div class="section-title">Generalidades</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Aeródromo:</td>
                    <td>{{ $reporte->aerodromo->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Pista:</td>
                    <td>{{ $reporte->pista->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Fecha y Hora del Impacto:</td>
                    <td>{{ $reporte->fecha }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Aeronave --}}
        <div class="section-title">Aeronave</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Aerolínea:</td>
                    <td>{{ $reporte->aerolinea->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Modelo de Aeronave:</td>
                    <td>{{ $reporte->modelo->modelo ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Matrícula de Aeronave:</td>
                    <td>{{ $reporte->matricula }}</td>
                </tr>
                <tr>
                    <td>Altitud en Pies:</td>
                    <td>{{ $reporte->Altitud }} pies</td>
                </tr>
                <tr>
                    <td>Velocidad a la que impactó (m/s):</td>
                    <td>{{ $reporte->Velocidad }} m/s</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Advertencia --}}
        <div class="section-title">Advertencia</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>¿Fue advertido por tránsito aéreo de la condición por Fauna? *</td>
                    <td>
                        @if (is_null($reporte->advertencia))
                            No especificado
                        @elseif ($reporte->advertencia)
                            Sí
                        @else
                            No
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Condiciones Atmosféricas y de Vuelo --}}
        <div class="section-title">Condiciones Atmosféricas y de Vuelo</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Luminosidad:</td>
                    <td>{{ $reporte->Luminosidad }}</td>
                </tr>
                <tr>
                    <td>Fase de Vuelo:</td>
                    <td>{{ $reporte->Fase_vuelo }}</td>
                </tr>
                <tr>
                    <td>Cielo:</td>
                    <td>{{ $reporte->cielo }}</td>
                </tr>
                <tr>
                    <td>Temperatura (°C):</td>
                    <td>{{ round($reporte->temperatura) }} °C</td>
                </tr>
                <tr>
                    <td>Velocidad del Viento (m/s):</td>
                    <td>{{ $reporte->viento_velocidad }}</td>
                </tr>
                <tr>
                    <td>Dirección del Viento:</td>
                    <td>{{ $reporte->viento_direccion }}</td>
                </tr>
                <tr>
                    <td>Condición Visual:</td>
                    <td>{{ $reporte->condicion_visual }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Detalles de Fauna --}}
        <div class="section-title">Detalles de Fauna</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Especie Impactada:</td>
                    <td>{{ $reporte->especie->nombre_cientifico ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Cantidad Observada:</td>
                    <td>{{ $reporte->fauna_observada }}</td>
                </tr>
                <tr>
                    <td>Cantidad Impactada:</td>
                    <td>{{ $reporte->fauna_impactada }}</td>
                </tr>
                <tr>
                    <td>Tamaño de la Especie:</td>
                    <td>{{ $reporte->fauna_tamano }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Piezas Afectadas --}}
        <div class="section-title">Piezas Afectadas</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Piezas Golpeadas:</td>
                    <td>
                        @if (!empty($partesGolpeadas) && count($partesGolpeadas) > 0)
                            {{ $partesGolpeadas->pluck('nombre')->join(', ') }}
                        @else
                            No hay piezas golpeadas.
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Piezas Dañadas:</td>
                    <td>
                        @if (!empty($partesDanadas) && count($partesDanadas) > 0)
                            {{ $partesDanadas->pluck('nombre')->join(', ') }}
                        @else
                            No hay piezas dañadas.
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Afectaciones --}}
        <div class="section-title">Afectaciones</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Consecuencia:</td>
                    <td>{{ $reporte->consecuencia }}</td>
                </tr>
                <tr>
                    <td>Tiempo de la aeronave fuera de servicio:</td>
                    <td>{{ $reporte->tiempo_fs }} Horas</td>
                </tr>
                <tr>
                    <td>Costo estimado en reparaciones o reemplazo de piezas:</td>
                    <td>${{ $reporte->costo_reparacion }}</td>
                </tr>
                <tr>
                    <td>Otros costos Estimados:</td>
                    <td>${{ $reporte->costo_otros }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Observaciones --}}
        <div class="section-title">Observaciones</div>
        <div class="observations-block">
            <strong>Comentarios:</strong>
            <p>{{ $reporte->observacion }}</p>
        </div>

        {{-- Sección: Autor --}}
        <div class="section-title">Autor</div>
        <table class="section-table">
            <tbody>
                <tr>
                    <td>Reportado Por:</td>
                    <td>{{ $reporte->user->name}}</td>
                </tr>
                <tr>
                    <td>Cargo:</td>
                    <td>{{ $reporte->cargo }}</td>
                </tr>
                <tr>
                    <td>Fecha de reporte:</td>
                    <td>{{ $reporte->created_at }}</td>
                </tr>
            </tbody>
        </table>

        {{-- ACTUALIZACIONES --}}
        @if($reporte->actualizaciones->isNotEmpty())
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
                @foreach($reporte->actualizaciones as $actualizacion)
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

    </div>

</body>
</html>
