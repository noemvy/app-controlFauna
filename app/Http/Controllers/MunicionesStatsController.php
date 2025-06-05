<?php

namespace App\Http\Controllers;

use App\Models\CatalogoInventario;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PivoteEvento;
use App\Models\PivotePatrullajeIntervencion;
use App\Models\ReporteImpactoAviar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class MunicionesStatsController extends Controller
{
        public function exportExcel(Request $request)
    {
        $filtro = $request->input('filtro_municiones', 'todos');
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

    $query1 = PivotePatrullajeIntervencion::select('catinventario_id');
    $query2 = PivoteEvento::select('catinventario_id');

    if ($fechaInicio && $fechaFin) {
        $query1->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        $query2->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    $union = $query1->unionAll($query2);

    $resultados = DB::table(DB::raw("({$union->toSql()}) as all_intervenciones"))
        ->mergeBindings($union->getQuery())
        ->select('catinventario_id', DB::raw('count(*) as total'))
        ->groupBy('catinventario_id')
        ->get()
        ->map(function ($item) {
            $nombre = CatalogoInventario::find($item->catinventario_id)?->nombre ?? 'Sin Nombre';
            return [
                'nombre' => $nombre,
                'total' => $item->total,
            ];
        });

        // Crear hoja Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'Municiones');
        $sheet->setCellValue('B1', 'Total de Municiones');

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
        header('Content-Disposition: attachment; filename="municiones_utilizadas.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
