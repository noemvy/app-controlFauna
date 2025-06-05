<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Especie;
use App\Models\Intervenciones;
use App\Models\IntervencionesEventoDraft;
use App\Models\ReporteImpactoAviar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class EspeciesStatsController extends Controller
{
    public function exportExcel(Request $request)
{
    $filtro = $request->input('filtro_fecha', 'todos');
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');

    // Si recibimos fechas personalizadas, las convertimos a Carbon y usamos esas
    if ($fechaInicio && $fechaFin) {
        $fechaInicio = Carbon::parse($fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($fechaFin)->endOfDay();
    } else {
        // Si no hay fechas personalizadas, aplicamos filtro predefinido
        switch ($filtro) {
            case 'hoy':
                $fechaInicio = Carbon::today()->startOfDay();
                $fechaFin = Carbon::today()->endOfDay();
                break;
            case 'semana':
                $fechaInicio = Carbon::now()->startOfWeek();
                $fechaFin = Carbon::now()->endOfWeek();
                break;
            case 'mes':
                $fechaInicio = Carbon::now()->startOfMonth();
                $fechaFin = Carbon::now()->endOfMonth();
                break;
            case 'ano':
                $fechaInicio = Carbon::now()->startOfYear();
                $fechaFin = Carbon::now()->endOfYear();
                break;
            default:
                $fechaInicio = null;
                $fechaFin = null;
        }
    }

    // Construcción de las consultas con el filtro de fechas (si hay)
    $query1 = IntervencionesEventoDraft::select('especies_id');
    $query2 = Intervenciones::select('especies_id');
    $query3 = ReporteImpactoAviar::select('especies_id');

    if ($fechaInicio && $fechaFin) {
        $query1->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        $query2->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        $query3->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    $union = $query1->unionAll($query2)->unionAll($query3);

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

    // Crear hoja Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados
    $sheet->setCellValue('A1', 'Especie');
    $sheet->setCellValue('B1', 'Total Avistamientos');

    // Agregar datos
    $row = 2;
    foreach ($resultados as $data) {
        $sheet->setCellValue('A' . $row, $data['nombre']);
        $sheet->setCellValue('B' . $row, $data['total']);
        $row++;
    }

    // Generar archivo
    $writer = new Xlsx($spreadsheet);

    // Enviar archivo para descarga
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="especies_avistamientos.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

}
