<div class="space-y-4 text-sm">
    <div>
        <strong>Aeródromo:</strong>
        <div>{{ $record->aerodromo->nombre ?? 'N/A' }}</div>
    </div>
    <div>
        <strong>Usuario:</strong>
        <div>{{ $record->user->name ?? 'N/A' }}</div>
    </div>
    <div>
        <strong>Estado:</strong>
        <div>
            @if ($record->estado === 'en_proceso')
                🟢 En Proceso
            @elseif ($record->estado === 'finalizado')
                🔴 Finalizado
            @else
                {{ ucfirst($record->estado) }}
            @endif
        </div>
    </div>
    <div>
        <strong>Inicio:</strong>
        <div>{{ $record->inicio }}</div>
    </div>
    <div>
        <strong>Fin:</strong>
        <div>{{ $record->fin ?? 'Aún sin finalizar' }}</div>
    </div>
    <div>
        <strong>Comentarios:</strong>
        <div>{{ $record->comentarios ?? 'Sin comentarios' }}</div>
    </div>
</div>
