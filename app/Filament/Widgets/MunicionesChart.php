<?php

// namespace App\Filament\Widgets;

// use App\Models\CatalogoInventario;
// use App\Models\Intervenciones;
// use App\Models\IntervencionesEventoDraft;
// use Filament\Widgets\ChartWidget;
// use Illuminate\Support\Facades\DB;
// class MunicionesChart extends ChartWidget
// {
//     protected static ?string $heading = 'Municiones Usadas';

//     protected function getData(): array
//     {
//         //Consultas para obtener las municiones mas usadas en las intervenciones
//         $query1 = IntervencionesEventoDraft::select('catinventario_id');
//         $query2 = Intervenciones::select('catinventario_id');

//         $union = $query1->unionAll($query2);

//         //Contar todas las municones que se usan
//         $resultados = DB::table(DB::raw("({$union->toSql()}) as all_municiones"))
//         ->mergeBindings($union->getQuery())
//         ->select('catinventario_id',DB::raw('count(*)as total'))
//         ->groupBy('catinventario_id')
//         ->get()
//         ->map(function($item){
//         $nombre = CatalogoInventario::find($item->catinventario_id)?->nombre ?? 'Sin Uso';
//         return [
//             'nombre'=> $nombre,
//             'total'=>$item->total,
//         ];
//         });

//         return [
//             'datasets' => [
//                 [
//                     'label' => 'Municiones',
//                     'data' => $resultados->pluck('total'),
//                     //COLORES PARA LAS ESTADISTICAS
//                     'backgroundColor' => [
//                     '#FF6384', // rojo
//                     '#36A2EB', // azul
//                     '#FFCE56', // amarillo
//                     '#4BC0C0', // turquesa
//                     '#9966FF', // morado
//                     '#FF9F40', // naranja
//                     '#C9CBCF', // gris
//             ],
//                     'borderColor' => [
//                     '#FF6384', // rojo
//                     '#36A2EB', // azul
//                     '#FFCE56', // amarillo
//                     '#4BC0C0', // turquesa
//                     '#9966FF', // morado
//                     '#FF9F40', // naranja
//                     '#C9CBCF', // gris
//             ],
//                 ],
//             ],
//             'labels' => $resultados->pluck('nombre'),
//         ];
//     }

//     protected function getType(): string
//     {
//         return 'doughnut';
//     }
// }
