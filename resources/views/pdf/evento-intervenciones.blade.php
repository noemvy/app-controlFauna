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
            margin: 0.5in;
            /* Mantener un margen razonable */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            /* Eliminar margen por defecto del body */
            /* Padding dentro del body, ajusta si necesitas más espacio al borde */
            padding: 0.5in;
            /* Usar padding en lugar de margin en body para controlar el área de contenido */
            font-size: 12px;
            line-height: 1.5;
        }

        /* Estilos del encabezado */
        .header {
            background-color: #004080;
            /* Azul oscuro */
            color: white;
            /* Letras blancas */
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
        table.section-table {
            /* Usamos una nueva clase para las tablas de sección */
            width: 100%;
            /* Asegura que la tabla use todo el ancho disponible */
            border-collapse: collapse;
            /* Elimina el espacio entre bordes de celdas */
            margin-top: 10px;
            /* Espacio entre secciones/tablas */
            margin-bottom: 20px;
            /* Espacio después de cada tabla */
            page-break-inside: auto;
            /* Permite que la tabla se rompa entre páginas si es necesario */
            table-layout: auto;
            /* Permitir ajuste automático basado en contenido y anchos */
        }

        /* Estilos de las celdas de encabezado y datos de las tablas de sección */
        .section-table th,
        .section-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            white-space: pre-wrap;
            /* Mantiene los saltos de línea existentes en el texto */
            word-break: break-word;
            /* Permite que palabras largas se rompan para evitar desbordamiento */
        }

        /* --- Ajustes para aprovechar el ancho y mejorar la presentación en tablas de sección --- */

        /* Define anchos relativos para las columnas 'Campo' y 'Dato' */
        /* La primera columna ('Campo') */
        .section-table td:nth-child(1) {
            width: 40%;
            /* Ajusta este porcentaje para el nombre del campo */
        }

        /* La segunda columna ('Dato') */
        .section-table td:nth-child(2) {
            width: 60%;
            /* Usa el porcentaje restante para la columna de datos */
        }

        /* Estilos para los títulos de sección */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            /* Espacio antes del título de sección */
            margin-bottom: 5px;
            /* Espacio después del título */
            page-break-after: avoid;
            /* Evita que el título se separe de la tabla siguiente */
        }


        /* --- Reglas de salto de página --- */

        /* Regla para filas de tablas de sección */
        .section-table tr {
            page-break-inside: avoid;
            /* Evita que una fila individual se rompa entre páginas */
            page-break-after: auto;
            /* Permite un salto de página después de una fila si es necesario */
        }


        .page-break {
            /* Fuerza un salto de página antes del elemento con esta clase */
            page-break-before: always;
        }

        /* Permite que estos elementos se rompan internamente si es necesario */
        div,
        p,
        td {
            page-break-inside: auto;
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

        {{-- Sección: DATOS DEL EVENTO --}}
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
        {{-- Seccion: Datos del Clima  --}}
        <div class="section-title">Datos de Ubicación y Clima</div>
        <table class="section-table">
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
                    <td>Cantidad :</td>
                    <td>{{ $reporte->sacrificados }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Sección: Munición Utilizada --}}
<div class="section-title">Equipo/Munición Utilizada</div>

<table class="section-table">
    <tbody>
        @foreach ($municionesInfo as $municion)
            <tr>
                <td>{{ $municion['nombre'] }}</td>
                <td>{{ $municion['accion'] }}</td>
                <td>{{ $municion['cantidad_utilizada'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>



        {{-- Sección: Municion Utilizada --}}
        <div class="section-title">Comentarios</div>
        <table class="section-table">
            <tr>
                <td>Comentarios:</td>
                <td>{{$reporte->comentarios}}</td>
            </tr>
    </div>
</body>
</html>
