<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IntervencionesEventoDraft;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EfectividadController extends Controller
{
    public function exportExcel(Request $request)
    {
        $especieId = $request->query('especie_id');
        $municionId = $request->query('municion_id');

        $query = IntervencionesEventoDraft::with(['pivoteEvento.catalogoInventario'])
            ->select('id', 'especies_id', 'vistos', 'sacrificados', 'dispersados');

        if ($especieId) {
            $query->where('especies_id', $especieId);
        }

        $intervenciones = $query->get();

        $estadisticas = [];

        foreach ($intervenciones as $intervencion) {
            foreach ($intervencion->pivoteEvento as $pivote) {
                if (!$pivote->catalogoInventario || !$pivote->catalogoInventario->es_consumible) {
                    continue;
                }

                if ($municionId && $pivote->catalogoInventario->id != $municionId) {
                    continue;
                }

                $clave = $intervencion->especie . ' - ' . $pivote->catalogoInventario->nombre;

                if (!isset($estadisticas[$clave])) {
                    $estadisticas[$clave] = [
                        'especie' => $intervencion->especies_id,
                        'municion' => $pivote->catalogoInventario->nombre,
                        'vistos' => 0,
                        'sacrificados' => 0,
                        'dispersados' => 0,
                        'cantidad_utilizada' => 0,
                    ];
                }

                $estadisticas[$clave]['vistos'] += $intervencion->vistos;
                $estadisticas[$clave]['sacrificados'] += $intervencion->sacrificados;
                $estadisticas[$clave]['dispersados'] += $intervencion->dispersados;
                $estadisticas[$clave]['cantidad_utilizada'] += $pivote->cantidad_utilizada;
            }
        }

        // Generar Excel con PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'Especie');
        $sheet->setCellValue('B1', 'Munición');
        $sheet->setCellValue('C1', 'Vistos');
        $sheet->setCellValue('D1', 'Sacrificados');
        $sheet->setCellValue('E1', 'Dispersados');
        $sheet->setCellValue('F1', 'Cantidad Utilizada');

        // Datos
        $row = 2;
        foreach ($estadisticas as $item) {
            $sheet->setCellValue("A{$row}", $item['especie']);
            $sheet->setCellValue("B{$row}", $item['municion']);
            $sheet->setCellValue("C{$row}", $item['vistos']);
            $sheet->setCellValue("D{$row}", $item['sacrificados']);
            $sheet->setCellValue("E{$row}", $item['dispersados']);
            $sheet->setCellValue("F{$row}", $item['cantidad_utilizada']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'efectividad_municiones.xlsx';

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
