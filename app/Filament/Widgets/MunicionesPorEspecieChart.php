<?php

namespace App\Filament\Widgets;

use App\Models\Intervenciones;
use App\Models\IntervencionesEventoDraft;
use App\Models\PivoteEvento;
use Filament\Widgets\ChartWidget;

class MunicionesPorEspecieChart extends ChartWidget
{
    protected static ?string $heading = 'Municiones Utilizadas por Especie';

    protected function getData(): array
    {
    // Obtener los registros de PivoteEvento con especie
        $datos = collect();

        // 🟡 EVENTOS
        $eventos = IntervencionesEventoDraft::with(['especie', 'pivoteEvento.catalogoInventario'])->get();

        foreach ($eventos as $evento) {
            $nombreEspecie = $evento->especie?->nombre_cientifico ?? 'Sin especie';
            $municiones = $evento->pivoteEvento->pluck('catalogoInventario.nombre')->filter()->unique()->toArray();
            $datos[$nombreEspecie] = implode(', ', $municiones);
        }

        // 🔵 PATRULLAJES
        $intervenciones = Intervenciones::with(['especie', 'pivote.catalogoInventario'])->get();

        foreach ($intervenciones as $intervencion) {
            $nombreEspecie = $intervencion->especie?->nombre_cientifico ?? 'Sin especie';
            $municiones = $intervencion->pivote->pluck('catalogoInventario.nombre')->filter()->unique()->toArray();

            if ($datos->has($nombreEspecie)) {
                $datos[$nombreEspecie] .= ', ' . implode(', ', $municiones);
                $datos[$nombreEspecie] = collect(explode(', ', $datos[$nombreEspecie]))->unique()->implode(', ');
            } else {
                $datos[$nombreEspecie] = implode(', ', $municiones);
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Municiones utilizadas',
                    'data' => $datos->keys()->map(fn ($key) => 1),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                ],
            ],
            'labels' => $datos->map(fn ($municiones, $especie) => "{$especie}: {$municiones}")->values()->toArray(),
        ];
    }





    protected function getType(): string
    {
        return 'bar';
    }

}
