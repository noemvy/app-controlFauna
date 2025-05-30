<?php

namespace App\Filament\Widgets;

use App\Models\Especie;
use App\Models\Intervenciones;
use App\Models\IntervencionesEventoDraft;
use App\Models\ReporteImpactoAviar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
class EstadisticaEspeciesChart extends ChartWidget
{
    protected static ?string $heading = 'Especies Vistas';

    protected function getData(): array
    {
        //Consultas para obtner datos de todas las intervenciones en diferentes modelo
        $query1 = IntervencionesEventoDraft::select('especies_id');
        $query2 = Intervenciones::select('especies_id');
        $query3 = ReporteImpactoAviar::select('especies_id');

        $union = $query1->unionAll($query2)->unionAll($query3);

        // Consulta para contar las especies en intervenciones
        $resultados = DB::table(DB::raw("({$union->toSql()}) as all_intervenciones"))
        ->mergeBindings($union->getQuery())
        ->select('especies_id',DB::raw('count(*) as total'))
        ->groupBy('especies_id')
        ->get()
        ->map(function($item){
            $nombre = Especie::find($item->especies_id)?->nombre_cientifico ?? 'Desconocida';
            return [
                'nombre'=>$nombre,
                'total'=> $item->total,
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Avistamientos',
                    'data' => $resultados->pluck('total'),
                    //COLORES PARA LAS ESTADISTICAS
                    'backgroundColor' => [
                    '#FF6384', // rojo
                    '#36A2EB', // azul
                    '#FFCE56', // amarillo
                    '#4BC0C0', // turquesa
                    '#9966FF', // morado
                    '#FF9F40', // naranja
                    '#C9CBCF', // gris
            ],
                    'borderColor' => [
                    '#FF6384', // rojo
                    '#36A2EB', // azul
                    '#FFCE56', // amarillo
                    '#4BC0C0', // turquesa
                    '#9966FF', // morado
                    '#FF9F40', // naranja
                    '#C9CBCF', // gris
            ],
                ],
            ],
            'labels' => $resultados->pluck('nombre'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
