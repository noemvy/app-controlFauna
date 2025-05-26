<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Impacto con Fauna {{ $reporte->codigo }}</title>
    <style>
        /* Estilos generales de la página */
        @page {
            /* Margen de la página */
            margin: 0.5in; /* Mantener un margen razonable */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Eliminar margen por defecto del body */
            /* Padding dentro del body, ajusta si necesitas más espacio al borde */
            padding: 0.5in; /* Usar padding en lugar de margin en body para controlar el área de contenido */
            font-size: 12px;
            line-height: 1.5;
        }

        /* Estilos del encabezado */
        .header {
            background-color: #004080; /* Azul oscuro */
            color: white; /* Letras blancas */
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            /* Evita que el encabezado se separe de la primera parte del contenido */
            page-break-after: avoid;
        }

        /* Estilos del contenedor principal de contenido */
        .content {
            margin-top: 20px;
        }

        /* Estilos de las tablas de sección */
        table.section-table { /* Usamos una nueva clase para las tablas de sección */
            width: 100%; /* Asegura que la tabla use todo el ancho disponible */
            border-collapse: collapse; /* Elimina el espacio entre bordes de celdas */
            margin-top: 10px; /* Espacio entre secciones/tablas */
            margin-bottom: 20px; /* Espacio después de cada tabla */
            page-break-inside: auto; /* Permite que la tabla se rompa entre páginas si es necesario */
            table-layout: auto; /* Permitir ajuste automático basado en contenido y anchos */
        }

        /* Estilos de las celdas de encabezado y datos de las tablas de sección */
        .section-table th,
        .section-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            white-space: pre-wrap; /* Mantiene los saltos de línea existentes en el texto */
            word-break: break-word; /* Permite que palabras largas se rompan para evitar desbordamiento */
        }

        /* --- Ajustes para aprovechar el ancho y mejorar la presentación en tablas de sección --- */

        /* Define anchos relativos para las columnas 'Campo' y 'Dato' */
        /* La primera columna ('Campo') */
        .section-table td:nth-child(1) {
            width: 40%; /* Ajusta este porcentaje para el nombre del campo */
        }

        /* La segunda columna ('Dato') */
        .section-table td:nth-child(2) {
            width: 60%; /* Usa el porcentaje restante para la columna de datos */
        }

        /* Estilos para los títulos de sección */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px; /* Espacio antes del título de sección */
            margin-bottom: 5px; /* Espacio después del título */
            page-break-after: avoid; /* Evita que el título se separe de la tabla siguiente */
        }


        /* --- Reglas de salto de página --- */

        /* Regla para filas de tablas de sección */
        .section-table tr {
            page-break-inside: avoid; /* Evita que una fila individual se rompa entre páginas */
            page-break-after: auto; /* Permite un salto de página después de una fila si es necesario */
        }


        .page-break {
            /* Fuerza un salto de página antes del elemento con esta clase */
            page-break-before: always;
        }

        /* Permite que estos elementos se rompan internamente si es necesario */
        div, p, td {
            page-break-inside: auto;
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
                    <td>¿Fue advertido por tránsito aéreo de la condición por Fauna? * </td>
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
                    <td>Velocidad a la que impactó (m/s):</td>
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

        {{-- SALTO DE PÁGINA ANTES DE "Detalles de Fauna" (Opcional, ajusta si prefieres que rompa naturalmente) --}}
        {{-- Puedes usar un div o simplemente confiar en page-break-inside/after --}}
        {{-- <div class="page-break"></div> --}}


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
                {{-- Piezas Golpeadas --}}
                <tr>
                    <td>Piezas Golpeadas:</td>
                    <td>
                        @if (!empty($partesGolpeadas) && count($partesGolpeadas) > 0)
                            {{-- Unir los nombres con coma y espacio --}}
                            {{ $partesGolpeadas->pluck('nombre')->join(', ') }}
                        @else
                            No hay piezas golpeadas.
                        @endif
                    </td>
                </tr>
                {{-- Piezas Dañadas --}}
                <tr>
                    <td>Piezas Dañadas:</td>
                    <td>
                        @if (!empty($partesDanadas) && count($partesDanadas) > 0)
                            {{-- Unir los nombres con coma y espacio --}}
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
                    <td>Consecuencia: </td>
                    <td>{{ $reporte->consecuencia }}</td>
                </tr>
                <tr>
                    <td>Tiempo de la aeronave fuera de servicio: </td>
                    <td>{{ $reporte->tiempo_fs }} Horas</td>
                </tr>
                <tr>
                    <td>Costo estimado en reparaciones o reemplazo de piezas: </td>
                    <td>${{ $reporte->costo_reparacion }}</td>
                </tr>
                <tr>
                    <td>Otros costos Estimados: </td>
                    <td>${{ $reporte->costo_otros }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Observaciones (Fuera de la tabla) --}}
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

    </div>

</body>
</html>
