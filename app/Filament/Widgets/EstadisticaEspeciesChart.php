<?php

namespace App\Filament\Widgets;

use App\Models\Especie;
use App\Models\Intervenciones;
use App\Models\IntervencionesEventoDraft;
use App\Models\ReporteImpactoAviar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;

class EstadisticaEspeciesChart extends ChartWidget
{
    protected static ?string $heading = 'Especies Vistas';

    public ?string $filter = 'all';

    // Filtros disponibles en el widget
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'this_week' => 'Esta semana',
            'this_month' => 'Este mes',
            'all' => 'Todos',
        ];
    }

    // Tipo de gráfico
    protected function getType(): string
    {
        return 'bar';
    }
    protected function getData(): array
    {
        $query1 = IntervencionesEventoDraft::query();
        $query2 = Intervenciones::query();
        $query3 = ReporteImpactoAviar::query();

        // Aplicar filtros de fecha
        if ($this->filter === 'today') {
            $query1->whereDate('created_at', now());
            $query2->whereDate('created_at', now());
            $query3->whereDate('created_at', now());
        } elseif ($this->filter === 'this_week') {
            $query1->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $query2->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $query3->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->filter === 'this_month') {
            $query1->whereMonth('created_at', now()->month);
            $query2->whereMonth('created_at', now()->month);
            $query3->whereMonth('created_at', now()->month);
        }

        // Unión de consultas
        $union = $query1->select('especies_id')
            ->unionAll($query2->select('especies_id'))
            ->unionAll($query3->select('especies_id'));

        // Conteo agrupado por especie
        $resultados = DB::table(DB::raw("({$union->toSql()}) as all_intervenciones"))
            ->mergeBindings($union->getQuery())
            ->select('especies_id', DB::raw('count(*) as total'))
            ->groupBy('especies_id')
            ->get()
            ->map(function ($item) {
                $nombre = Especie::find($item->especies_id)?->nombre_cientifico ?? 'Desconocida';
                return [
                    'nombre' => $nombre,
                    'total' => $item->total,
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Avistamientos',
                    'data' => $resultados->pluck('total'),
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
            'labels' => $resultados->pluck('nombre'),
        ];
    }

}
