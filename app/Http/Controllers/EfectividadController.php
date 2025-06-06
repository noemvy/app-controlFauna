<?php

namespace App\Http\Controllers;

use App\Models\Intervenciones;
use Illuminate\Http\Request;
use App\Models\IntervencionesEventoDraft;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EfectividadController extends Controller
{

    public function export(Request $request)
    {
        $especies = $request->query('especies', []);
        $municiones = $request->query('municiones', []);

        $queryEventos = IntervencionesEventoDraft::with(['especie', 'pivoteEvento.catalogoInventario']);
        $queryPatrullaje = Intervenciones::with(['especie', 'pivote.catalogoInventario']);

        if (!empty($especies)) {
            $queryEventos->whereIn('especies_id', $especies);
            $queryPatrullaje->whereIn('especies_id', $especies);
        }
        if (!empty($municiones)) {
            $queryEventos->whereHas('pivoteEvento', function($q) use ($municiones) {
                $q->whereIn('catinventario_id', $municiones);
            });
            $queryPatrullaje->whereHas('pivote', function($q) use ($municiones) {
                $q->whereIn('catinventario_id', $municiones);
            });
        }

        $eventos = $queryEventos->get();
        $intervenciones = $queryPatrullaje->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'Especie');
        $sheet->setCellValue('B1', 'Munición');
        $sheet->setCellValue('C1', 'Vistos');
        $sheet->setCellValue('D1', 'Dispersados');
        $sheet->setCellValue('E1', 'Sacrificados');
        $sheet->setCellValue('F1', 'Cantidad Utilizada');
        $sheet->setCellValue('G1', 'Tipo de Operación');

        $row = 2;

        foreach ($eventos as $evento) {
            foreach ($evento->pivoteEvento as $municion) {
                $sheet->setCellValue("A{$row}", $evento->especie?->nombre_cientifico ?? 'Sin especie');
                $sheet->setCellValue("B{$row}", $municion->catalogoInventario?->nombre ?? 'Sin munición');
                $sheet->setCellValue("C{$row}", $evento->vistos ?? 0);
                $sheet->setCellValue("D{$row}", $evento->dispersados ?? 0);
                $sheet->setCellValue("E{$row}", $evento->sacrificados ?? 0);
                $sheet->setCellValue("F{$row}", $municion->cantidad_utilizada ?? 0);
                $sheet->setCellValue("G{$row}", 'Evento');
                $row++;
            }
        }

        foreach ($intervenciones as $intervencion) {
            foreach ($intervencion->pivote as $municion) {
                $sheet->setCellValue("A{$row}", $intervencion->especie?->nombre_cientifico ?? 'Sin especie');
                $sheet->setCellValue("B{$row}", $municion->catalogoInventario?->nombre ?? 'Sin munición');
                $sheet->setCellValue("C{$row}", $intervencion->vistos ?? 0);
                $sheet->setCellValue("D{$row}", $intervencion->dispersados ?? 0);
                $sheet->setCellValue("E{$row}", $intervencion->sacrificados?? 0);
                $sheet->setCellValue("F{$row}", $municion->cantidad_utilizada ?? 0);
                $sheet->setCellValue("G{$row}", 'Patrullaje');
                $row++;
            }
        }

        $writer = new Xlsx($spreadsheet);

        // Cabeceras para descarga
        $fileName = 'efectividad_municiones.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}

