<?php

namespace App\Filament\Resources\ReporteImpactoAviarResource\Pages;

use App\Filament\Resources\ReporteImpactoAviarResource;
use App\Models\ReporteImpactoAviar;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
class ListReporteImpactoAviars extends ListRecords
{
    protected static string $resource = ReporteImpactoAviarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Botón para el Nuevo Reporte
            Actions\CreateAction::make('Nuevo Reporte')
            ->label('Nuevo Reporte'),
            //Botón para descargar excel.
            Actions\action::make('exportReports')
                ->label('Descargar Reportes')
                ->icon('heroicon-o-arrow-down-on-square')
                ->color('warning')
                ->action(function () {
                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    // Agregar encabezados
                    $headers = [
                        'Código',
                        'Aeródromo',
                        'Pista',
                        'Fecha del impacto',
                        'Aerolínea',
                        'Modelo',
                        'Matricula',
                        'Advertido por tránsito aéreo?',
                        'Altitud',
                        'Velocidad',
                        'Luminosidad',
                        'Fase de vuelo',
                        'cielo',
                        'Temperatura',
                        'Velocidad del Viento',
                        'Dirección del viento',
                        'Condición Visual',
                        'Especie Impactada',
                        'Cantidad Observada',
                        'Cantidad impactada',
                        'Tamaño de la especie',
                        'Piezas impactadas',
                        'Piezas Dañadas',
                        'Consecuencias del impacto',
                        'Comentarios',
                        'Tiempo fuera de servicio (aeronave)',
                        'Costo de reparación',
                        'Otros costos',
                        'Estado del reporte',
                        'Autor',
                        'Creado el',
                          // Encabezados para actualizaciones
                        'Fecha Actualización',
                        'Autor Actualización',
                        'Contenido Actualización',
                    ];
                    $sheet->fromArray([$headers], null, 'A1');

                     // Obtener el reporte con relaciones necesarias
                        $reportes = ReporteImpactoAviar::with([
                            'aerodromo',
                            'pista',
                            'aerolinea',
                            'modelo',
                            'especie',
                            'partesGolpeadas',
                            'partesDanadas',
                            'user',
                            'actualizaciones',
                        ])->get();
                    $row = 2;

                    foreach ($reportes as $reporte) {
                        // Obtener los nombres de las piezas golpeadas
                        $partesGolpeadas = $reporte->partesGolpeadas->pluck('nombre')->implode(', ') ?: 'N/A';
                        // Obtener los nombres de las piezas dañadas
                        $partesDanadas = $reporte->partesDanadas->pluck('nombre')->implode(', ') ?: 'N/A';
                        if ($reporte->actualizaciones->isNotEmpty()) {
                        foreach ($reporte->actualizaciones as $actualizacion) {
                        $sheet->fromArray([
                            $reporte->codigo,
                            $reporte->aerodromo->codigo ?? '',
                            $reporte->pista->nombre ?? '',
                            !empty($reporte->fecha) ? Carbon::parse($reporte->fecha)->format('Y-m-d h:i: A') : '',
                            $reporte->aerolinea->nombre ?? '',
                            $reporte->modelo->modelo ?? '',
                            $reporte->matricula ?? '',
                            $reporte->advertido_transito === null
                                ? 'No especificado'
                                : ($reporte->advertido_transito == 1 ? 'Sí' : 'No'),
                            $reporte->Altitud ?? '',
                            $reporte->Velocidad ?? '',
                            $reporte->Luminosidad ?? '',
                            $reporte->Fase_vuelo ?? '',
                            $reporte->cielo ?? '',
                            $reporte->temperatura ?? '',
                            $reporte->viento_velocidad ?? '',
                            $reporte->viento_direccion ?? '',
                            $reporte->condicion_visual ?? '',
                            $reporte->fauna->nombre ?? '',
                            $reporte->fauna_observada ?? '',
                            $reporte->fauna_impactada ?? '',
                            $reporte->fauna_tamano ?? '',
                            $partesGolpeadas,
                            $partesDanadas,
                            $reporte->consecuencia ?? '',
                            $reporte->observacion ?? '',
                            $reporte->tiempo_fs ?? '',
                            $reporte->costo_reparacion ?? '',
                            $reporte->costo_otros ?? '',
                            $reporte->estado ?? '',
                            $reporte->user->name ?? '',
                            $reporte->created_at ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i A') : '',
                            // Datos de la actualización
                            $actualizacion->created_at ? Carbon::parse($actualizacion->created_at)->format('Y-m-d h:i A') : '',
                            $actualizacion->user->name ?? 'N/A',
                            $actualizacion->actualizacion ?? '',
                            !empty($reporte->created_at) ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i: A') : '',
                        ], null, "A$row");
                        $row++;
                    }
                }else{
                $sheet->fromArray([
                            $reporte->codigo,
                            $reporte->aerodromo->codigo ?? '',
                            $reporte->pista->nombre ?? '',
                            !empty($reporte->fecha) ? Carbon::parse($reporte->fecha)->format('Y-m-d h:i: A') : '',
                            $reporte->aerolinea->nombre ?? '',
                            $reporte->modelo->modelo ?? '',
                            $reporte->matricula ?? '',
                            $reporte->advertido_transito === null
                                ? 'No especificado'
                                : ($reporte->advertido_transito == 1 ? 'Sí' : 'No'),
                            $reporte->Altitud ?? '',
                            $reporte->Velocidad ?? '',
                            $reporte->Luminosidad ?? '',
                            $reporte->Fase_vuelo ?? '',
                            $reporte->cielo ?? '',
                            $reporte->temperatura ?? '',
                            $reporte->viento_velocidad ?? '',
                            $reporte->viento_direccion ?? '',
                            $reporte->condicion_visual ?? '',
                            $reporte->fauna->nombre ?? '',
                            $reporte->fauna_observada ?? '',
                            $reporte->fauna_impactada ?? '',
                            $reporte->fauna_tamano ?? '',
                            $partesGolpeadas,
                            $partesDanadas,
                            $reporte->consecuencia ?? '',
                            $reporte->observacion ?? '',
                            $reporte->tiempo_fs ?? '',
                            $reporte->costo_reparacion ?? '',
                            $reporte->costo_otros ?? '',
                            $reporte->estado ?? '',
                            $reporte->user->name ?? '',
                            $reporte->created_at ? Carbon::parse($reporte->created_at)->timezone('America/Panama')->format('Y-m-d h:i A') : '',
                            !empty($reporte->created_at) ? Carbon::parse($reporte->created_at)->timezone('America/Panama')->format('Y-m-d h:i: A') : '',
                            '', // Fecha actualización
                            '', // Autor actualización
                            '', // Contenido actualización
                        ], null, "A$row");
                        $row++;
            }
        }
                    // Guardar archivo temporalmente
                    $fileName = 'reportes de Impacto con Fauna.xlsx';
                    $tempFilePath = Storage::path($fileName);
                    $writer = new Xlsx($spreadsheet);
                    $writer->save($tempFilePath);

                    // Devolver archivo como respuesta de descarga
                    return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
                }),
        ];
    }

    public function getTitle(): string
    {
        return 'Reportes Impacto con Fauna'; //título
    }
}
