@extends('layouts.app')

@section('content')

<div class="w-full p-4 text-sm text-gray-700">
    <div class="border border-green-900 rounded-md overflow-hidden w-full">
        <table class="w-full border-collapse table-auto">
            <tbody>
                <tr class="bg-green-900 text-white">
                    <th class="p-2 border border-green-800 w-1/3">Tipo de Evento</th>
                    <td class="p-2 border border-green-800">{{ $record->tipo_evento ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900">Origen del Reporte</th>
                    <td class="p-2 border border-green-100">{{ $record->origen ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900">Especie</th>
                    <td class="p-2 border border-green-100">{{ $record->especie->nombre_cientifico }}</td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900">Atractivo para la Fauna</th>
                    <td class="p-2 border border-green-100">{{ $record->atractivo->nombre }}</td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900">Cantidad Vista</th>
                    <td class="p-2 border border-green-100">{{ $record->vistos ?? 0 }}</td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900">Cantidad Dispersada</th>
                    <td class="p-2 border border-green-100">{{ $record->dispersados ?? 0 }}</td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900">Cantidad Sacrificada</th>
                    <td class="p-2 border border-green-100">{{ $record->sacrificados }}</td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900 align-top">Herramienta Usada</th>
                    <td class="p-2 border border-green-100">
                        <div class="space-y-1">
                            @foreach ($record->pivoteEvento as $pivote)
                                <div class="bg-green-100 text-green-900 px-2 py-0.5 rounded text-xs">
                                    {{ $pivote->catalogoInventario->nombre }}
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="p-2 border border-green-100 bg-green-50 text-green-900 align-top">Comentarios</th>
                    <td class="p-2 border border-green-100 italic">
                        {{ $record->comentarios ?? 'Sin comentarios' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection
