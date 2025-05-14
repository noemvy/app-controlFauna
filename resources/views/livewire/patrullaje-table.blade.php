<div>
    <h2 class="text-xl font-bold mb-4">Lista de patrullajes</h2>
    <ul class="space-y-2">
        @foreach ($patrullajes as $patrullaje)
            <li class="p-2 bg-gray-100 rounded">
                {{ $patrullaje->nombre ?? 'Sin nombre' }} - {{ $patrullaje->fecha ?? 'Sin fecha' }}
            </li>
        @endforeach
    </ul>
</div>
