@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-green-100 p-6 rounded-xl shadow space-y-4">
    <div class="flex items-center gap-2 mb-4">
        <x-heroicon-o-clipboard-document-check class="h-6 w-6 text-green-800" />
        <h2 class="text-lg font-bold text-green-900">Detalles del Patrullaje</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <!-- Aeródromo -->
        <div class="bg-white rounded-2xl p-5 shadow flex flex-col gap-1">
            <div class="flex items-center gap-2 text-green-700 font-semibold">
                <x-heroicon-o-map-pin class="w-5 h-5" />
                Aeródromo
            </div>
            <div>{{ $patrullaje->aerodromo->nombre ?? 'N/A' }}</div>
        </div>

        <!-- Usuario -->
        <div class="bg-white rounded-2xl p-5 shadow flex flex-col gap-1">
            <div class="flex items-center gap-2 text-green-700 font-semibold">
                <x-heroicon-o-user class="w-5 h-5" />
                Usuario
            </div>
            <div>{{ $patrullaje->user->name ?? 'N/A' }}</div>
        </div>

        <!-- Estado -->
        <div class="rounded-2xl p-5 shadow flex flex-col gap-1
            {{ $patrullaje->estado === 'finalizado' ? 'bg-red-100' : 'bg-white' }}">
            <div class="flex items-center gap-2 font-semibold
                {{ $patrullaje->estado === 'finalizado' ? 'text-red-600' : 'text-green-700' }}">
                <x-heroicon-o-clock class="w-5 h-5" />
                Estado
            </div>
            <div>
                {{ ucfirst($patrullaje->estado) }}
            </div>
        </div>

        <!-- Inicio -->
        <div class="bg-white rounded-2xl p-5 shadow flex flex-col gap-1">
            <div class="flex items-center gap-2 text-green-700 font-semibold">
                <x-heroicon-o-calendar-days class="w-5 h-5" />
                Inicio
            </div>
            <div>{{ $patrullaje->inicio }}</div>
        </div>

        <!-- Fin -->
        <div class="bg-white rounded-2xl p-5 shadow flex flex-col gap-1">
            <div class="flex items-center gap-2 text-green-700 font-semibold">
                <x-heroicon-o-calendar-days class="w-5 h-5" />
                Fin
            </div>
            <div>{{ $patrullaje->fin ?? 'Aún sin finalizar' }}</div>
        </div>

        <!-- Comentarios -->
        <div class="bg-white rounded-2xl p-5 shadow flex flex-col gap-1">
            <div class="flex items-center gap-2 text-green-700 font-semibold">
                <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                Comentarios
            </div>
            <div>{{ $patrullaje->comentarios ?? 'Sin comentarios' }}</div>
        </div>
    </div>

    <!-- Intervenciones -->
    <div class="mt-8">
        <h3 class="text-md font-semibold text-green-900 mb-2">Intervenciones</h3>

        @if ($intervenciones->count())
            <div class="overflow-x-auto rounded-2xl border border-green-400 shadow-lg">
                <table class="w-full table-auto text-sm rounded-2xl overflow-hidden text-center">
                    <thead class="bg-green-200">
                        <tr>
                            <th class="px-3 py-2 whitespace-nowrap rounded-tl-2xl">Código</th>
                            <th class="px-3 py-2 whitespace-nowrap">Especie</th>
                            <th class="px-3 py-2 whitespace-nowrap">Atractivo</th>
                            <th class="px-3 py-2 whitespace-nowrap">Vistos</th>
                            <th class="px-3 py-2 whitespace-nowrap">Sacrificados</th>
                            <th class="px-3 py-2 whitespace-nowrap">Dispersados</th>
                            <th class="px-3 py-2 whitespace-nowrap">Herramienta</th>
                            <th class="px-3 py-2 whitespace-nowrap rounded-tr-2xl">Comentarios</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-green-300">
                        @foreach ($intervenciones as $intervencion)
                            <tr class="align-top hover:bg-green-50 transition">
                                <td class="px-3 py-2">{{ $intervencion->id ?? 'N/A' }}</td>
                                <td class="px-3 py-2">{{ $intervencion->especie->nombre_cientifico ?? 'N/A' }}</td>
                                <td class="px-3 py-2">{{ $intervencion->atractivo->nombre ?? 'N/A' }}</td>
                                <td class="px-3 py-2">{{ $intervencion->vistos }}</td>
                                <td class="px-3 py-2">{{ $intervencion->sacrificados }}</td>
                                <td class="px-3 py-2">{{ $intervencion->dispersados }}</td>
                                <td class="px-3 py-2 text-green-700 font-medium">
                                    @if ($intervencion->pivote->isNotEmpty())
                                        {{ $intervencion->pivote->map(fn($pivote) => $pivote->catalogoInventario->nombre ?? 'N/A')->join(', ') }}
                                    @else
                                        <span class="italic text-green-400">Sin herramientas</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">{{ $intervencion->comentarios ?? 'Sin comentarios' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-green-700 mt-2 italic">No hay intervenciones registradas.</p>
        @endif
    </div>

    <button
        onclick="window.location='{{ route('filament.dashboard.resources.patrullajes.index') }}'"
        class="mt-6 px-6 py-3 bg-green-700 text-white font-semibold rounded-3xl shadow-lg
               hover:bg-green-800 transition-transform transform hover:scale-105 active:scale-95
               focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
        Regresar a página
    </button>
</div>
@endsection
