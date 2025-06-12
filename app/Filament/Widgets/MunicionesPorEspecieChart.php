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
    $conteoMunicionesPorEspecie = collect();
    $nombresMunicionesPorEspecie = collect();

    // 🔵 EVENTOS
    $eventos = IntervencionesEventoDraft::with(['especie', 'pivoteEvento.catalogoInventario'])->get();

    foreach ($eventos as $evento) {
        $nombreEspecie = $evento->especie?->nombre_cientifico ?? 'Sin especie';
        $municiones = $evento->pivoteEvento->pluck('catalogoInventario.nombre')->filter();

        $conteo = $municiones->count();
        $nombres = $municiones->toArray();

        $conteoMunicionesPorEspecie[$nombreEspecie] = ($conteoMunicionesPorEspecie[$nombreEspecie] ?? 0) + $conteo;

        $nombresMunicionesPorEspecie[$nombreEspecie] = array_merge(
            $nombresMunicionesPorEspecie[$nombreEspecie] ?? [],
            $nombres
        );
    }

    // 🟡 PATRULLAJES
    $intervenciones = Intervenciones::with(['especie', 'pivote.catalogoInventario'])->get();

    foreach ($intervenciones as $intervencion) {
        $nombreEspecie = $intervencion->especie?->nombre_cientifico ?? 'Sin especie';
        $municiones = $intervencion->pivote->pluck('catalogoInventario.nombre')->filter();

        $conteo = $municiones->count();
        $nombres = $municiones->toArray();

        $conteoMunicionesPorEspecie[$nombreEspecie] = ($conteoMunicionesPorEspecie[$nombreEspecie] ?? 0) + $conteo;

        $nombresMunicionesPorEspecie[$nombreEspecie] = array_merge(
            $nombresMunicionesPorEspecie[$nombreEspecie] ?? [],
            $nombres
        );
    }

    // Crear etiquetas y valores únicos de municiones
    $labels = [];
    $values = [];

    foreach ($conteoMunicionesPorEspecie as $especie => $conteo) {
        $municionesUnicas = collect($nombresMunicionesPorEspecie[$especie] ?? [])->unique()->implode(', ');
        $labels[] = "{$especie}: {$municionesUnicas}";
        $values[] = $conteo;
    }
    return [
            'datasets' => [
                [
                    'label' => 'Total de municiones utilizadas',
                    'data' => $values,
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#C9CBCF',
                    ],
                    'borderColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#C9CBCF',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
}





    protected function getType(): string
    {
        return 'bar';
    }



}
