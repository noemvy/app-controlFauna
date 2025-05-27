<?php

namespace App\Filament\Resources\IntervencionesEventoDraftResource\Pages;

use App\Filament\Resources\IntervencionesEventoDraftResource;
use App\Models\CatalogoInventario;
use App\Models\IntervencionesEventoDraft;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class ListIntervencionesEventoDrafts extends ListRecords
{
    protected static string $resource = IntervencionesEventoDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            /*----------------------------BOTON DE NUEVA INTERVENCION--------------------------------*/
            Actions\CreateAction::make('Nueva intervención')
                ->label('Nueva Interveción'),
            // Botón para descargar excel.
            Actions\action::make('exportReports')
                ->label('Descargar Reportes')
                ->icon('heroicon-o-arrow-down-on-square')
                ->color('warning')
                ->action(function () {
                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    // Agregar encabezados
                    $headers = [
                        'Codigo',
                        'Usuario',
                        'Tipo de Evento',
                        'Origen del Reporte',
                        'Coordenada X',
                        'Coordenada Y',
                        'Temperatura',
                        'Viento',
                        'Humedad',
                        'Grupo',
                        'Especie',
                        'Atractivo',
                        'Vistos',
                        'Dispersados',
                        'Sacrificados',
                        'Herramienta Utilizada',
                        'Tipo de Acción Realizada',
                        'Cantidad utilizada',
                        'Comentarios',
                        'Fecha creación',
                    ];
                    $sheet->fromArray([$headers], null, 'A1');

                    // Agregar datos desde la base de datos
                    $reportes = IntervencionesEventoDraft::all();
                    $row = 2;
                    foreach ($reportes as $reporte) {
    if (!empty($reporte->municion_utilizada)) {
        foreach ($reporte->municion_utilizada as $municion) {
            $catalogo = CatalogoInventario::with('acciones')->find($municion['catinventario_id']);
            if ($catalogo) {
                $sheet->fromArray([
                    $reporte->id,
                    $reporte->user_id,
                    $reporte->tipo_evento,
                    $reporte->origen,
                    $reporte->coordenada_x,
                    $reporte->coordenada_y,
                    $reporte->temperatura,
                    $reporte->viento,
                    $reporte->humedad,
                    $reporte->especies->grupo->nombre ?? '',
                    $reporte->especies_id,
                    $reporte->atractivo->nombre ?? '',
                    $reporte->visto,
                    $reporte->dispersados,
                    $reporte->sacrificados,
                    $catalogo->nombre,
                    $catalogo->acciones->nombre ?? 'Sin acción',
                    $municion['cantidad_utilizada'],
                    $reporte->comentarios,
                    !empty($reporte->created_at) ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i A') : '',
                ], null, "A$row");
                $row++;
            }
        }
    } else {
        // Si no hay munición utilizada, registrar el resto de los datos sin herramienta
        $sheet->fromArray([
            $reporte->id,
            $reporte->user_id,
            $reporte->tipo_evento,
            $reporte->origen,
            $reporte->coordenada_x,
            $reporte->coordenada_y,
            $reporte->temperatura,
            $reporte->viento,
            $reporte->humedad,
            $reporte->especies->grupo->nombre ?? '',
            $reporte->especies_id,
            $reporte->atractivo->nombre ?? '',
            $reporte->visto,
            $reporte->dispersados,
            $reporte->sacrificados,
            '', // Herramienta
            '', // Acción
            '', // Cantidad
            $reporte->comentarios,
            !empty($reporte->created_at) ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i A') : '',
        ], null, "A$row");
        $row++;
    }
}


                    // Guardar archivo temporalmente
                    $fileName = 'Reporte Evento Intervenciones.xlsx';
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
        return 'Reportes Evento Intervenciones'; // título
    }
}
