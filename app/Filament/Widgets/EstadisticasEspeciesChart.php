<?php

namespace App\Filament\Widgets;


use App\Models\IntervencionesEventoDraft;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EstadisticasEspeciesChart extends ChartWidget
{
    protected static ?string $heading = 'Especies más vistas en intervenciones';

    protected function getData(): array
    {
        // Consulta para contar las especies en intervenciones
        $resultados = IntervencionesEventoDraft::select('especies_id', DB::raw('count(*) as total'))
            ->groupBy('especies_id')
            ->with('especie')
            ->get()
            ->map(function ($item) {
                return [
                    'nombre' => $item->especie->nombre_cientifico ?? 'Desconocida',
                    'total' => $item->total,
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Avistamientos',
                    'data' => $resultados->pluck('total'),
                ],
            ],
            'labels' => $resultados->pluck('nombre'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
