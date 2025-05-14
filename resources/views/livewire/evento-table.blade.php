<div>
    <h2 class="text-xl font-bold mb-4">Lista de eventos</h2>
    <ul class="space-y-2">
        @foreach ($eventos as $evento)
            <li class="p-2 bg-gray-100 rounded">
                {{ $evento->titulo ?? 'Sin título' }} - {{ $evento->created_at->format('d/m/Y') }}
            </li>
        @endforeach
    </ul>
</div>
