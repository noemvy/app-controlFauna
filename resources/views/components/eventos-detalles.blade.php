<div class="bg-white p-6 text-gray-700 text-sm">
    <div class="grid grid-cols-2 gap-x-6 gap-y-4">

        <div>
            <strong class="text-gray-600">Tipo de Evento:</strong>
            <div>{{ $record->tipo_evento ?? 'N/A' }}</div>
        </div>

        <div>
            <strong class="text-gray-600">Origen del Reporte:</strong>
            <div>{{ $record->origen ?? 'N/A' }}</div>
        </div>

        <div>
            <strong class="text-gray-600">Especie:</strong>
            <div>{{ $record->especie->nombre_cientifico }}</div>
        </div>

        <div>
            <strong class="text-gray-600">Atractivo para la Fauna:</strong>
            <div>{{ $record->atractivo->nombre }}</div>
        </div>

        <div>
            <strong class="text-gray-600">Cantidad Vista:</strong>
            <div>{{ $record->vistos ?? 0 }}</div>
        </div>

        <div>
            <strong class="text-gray-600">Cantidad Dispersada:</strong>
            <div>{{ $record->dispersados ?? 0 }}</div>
        </div>

        <div>
            <strong class="text-gray-600">Cantidad Sacrificada:</strong>
            <div>{{ $record->sacrificados }}</div>
        </div>

        <div>
            <strong class="text-gray-600">Herramienta Usada:</strong>
            <div class="space-y-1 mt-1">
                @foreach ($record->pivoteEvento as $pivote)
                    <div class="bg-gray-100 px-2 py-1 rounded">{{ $pivote->catalogoInventario->nombre }}</div>
                @endforeach
            </div>
        </div>

        <div class="col-span-2">
            <strong class="text-gray-600">Comentarios:</strong>
            <div class="mt-1 italic text-gray-800">{{ $record->comentarios ?? 'Sin comentarios' }}</div>
        </div>

    </div>
</div>
