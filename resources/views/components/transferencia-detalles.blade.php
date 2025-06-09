<div class="space-y-4 text-sm">
    <div>
        <strong>Aeródromo Origen:</strong>
        <div>{{ $record->transferenciaMuniciones->aerodromoOrigen->nombre ?? 'N/A' }}</div>
    </div>
    <div>
        <strong>Aeródromo Destino:</strong>
        <div>{{ $record->transferenciaMuniciones->aerodromoDestino->nombre?? 'N/A' }}</div>
    </div>
    <div>
        <strong>Cantidad Transferida:</strong>
        <div>{{ $record->transferenciaMuniciones->cantidad ?? 'N/A' }}</div>
    </div>
    <div>
        <strong>Fecha y Hora:</strong>
        <div>{{ $record->transferenciaMuniciones->updated_at }}</div>
    </div>
    <div>
        <strong>Usuario:</strong>
        <div>{{ $record->transferenciaMuniciones->usuario->name ?? 'Sin Usuario' }}</div>
    </div>
    <div>
        <strong>Comentarios:</strong>
        <div>{{ $record->transferenciaMuniciones->observaciones ?? 'Sin comentarios' }}</div>
    </div>
</div>
