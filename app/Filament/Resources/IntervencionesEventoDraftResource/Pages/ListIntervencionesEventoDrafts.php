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
use Filament\Actions\Action;

class ListIntervencionesEventoDrafts extends ListRecords
{
    protected static string $resource = IntervencionesEventoDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            /*----------------------------BOTON DE NUEVA INTERVENCION--------------------------------*/
            Actions\CreateAction::make('Nueva intervención')
                ->label('Nueva Interveción'),
            Action::make('exportReports')
                ->label('Reportes en Excel')
                ->icon('lucide-file-x-2')
                ->color('info')
                ->action(function () {
                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
        // Encabezados
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
            // Encabezados para actualizaciones
            'Fecha Actualización',
            'Autor Actualización',
            'Contenido Actualización',
        ];
        $sheet->fromArray([$headers], null, 'A1');

        // Obtener todos los reportes con relaciones necesarias
        $reportes = IntervencionesEventoDraft::with([
            'user',
            'especie.grupo',
            'atractivo',
            'pivoteEvento.catalogoInventario.acciones',
            'actualizacionesEvento.user' // Relación para traer usuario de actualizaciones
        ])->get();

        $row = 2;

        foreach ($reportes as $reporte) {
            // Si tiene municiones en pivoteEvento, recorremos cada una
            if ($reporte->pivoteEvento->isNotEmpty()) {
                foreach ($reporte->pivoteEvento as $pivote) {
                    $catalogo = $pivote->catalogoInventario;
                    $accion = $catalogo->acciones ?? null;

                    // Si hay actualizaciones, hacer una fila por cada actualización
                    if ($reporte->actualizacionesEvento->isNotEmpty()) {
                        foreach ($reporte->actualizacionesEvento as $actualizacion) {
                            $sheet->fromArray([
                                $reporte->id,
                                $reporte->user->name ?? 'N/A',
                                $reporte->tipo_evento,
                                $reporte->origen,
                                $reporte->coordenada_x,
                                $reporte->coordenada_y,
                                $reporte->temperatura,
                                $reporte->viento,
                                $reporte->humedad,
                                $reporte->especies->grupo->nombre ?? '',
                                $reporte->especies->nombre ?? '',
                                $reporte->atractivo->nombre ?? '',
                                $reporte->visto,
                                $reporte->dispersados,
                                $reporte->sacrificados,
                                $catalogo->nombre ?? '',
                                $accion->nombre ?? 'Sin acción',
                                $pivote->cantidad_utilizada ?? '',
                                $reporte->comentarios,
                                $reporte->created_at ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i A') : '',
                                // Datos de la actualización
                                $actualizacion->created_at ? Carbon::parse($actualizacion->created_at)->format('Y-m-d h:i A') : '',
                                $actualizacion->user->name ?? 'N/A',
                                $actualizacion->actualizacion ?? '',
                            ], null, "A$row");

                            $row++;
                        }
                    } else {
                        // Sin actualizaciones: fila normal con munición
                        $sheet->fromArray([
                            $reporte->id,
                            $reporte->user->name ?? 'N/A',
                            $reporte->tipo_evento,
                            $reporte->origen,
                            $reporte->coordenada_x,
                            $reporte->coordenada_y,
                            $reporte->temperatura,
                            $reporte->viento,
                            $reporte->humedad,
                            $reporte->especies->grupo->nombre ?? '',
                            $reporte->especies->nombre ?? '',
                            $reporte->atractivo->nombre ?? '',
                            $reporte->visto,
                            $reporte->dispersados,
                            $reporte->sacrificados,
                            $catalogo->nombre ?? '',
                            $accion->nombre ?? 'Sin acción',
                            $pivote->cantidad_utilizada ?? '',
                            $reporte->comentarios,
                            $reporte->created_at ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i A') : '',
                            '', // Fecha actualización
                            '', // Autor actualización
                            '', // Contenido actualización
                        ], null, "A$row");

                        $row++;
                    }
                }
            } else {
                // Reporte sin municiones en pivoteEvento

                // Si tiene actualizaciones, una fila por cada actualización
                if ($reporte->actualizacionesEvento->isNotEmpty()) {
                    foreach ($reporte->actualizacionesEvento as $actualizacion) {
                        $sheet->fromArray([
                            $reporte->id,
                            $reporte->user->name ?? 'N/A',
                            $reporte->tipo_evento,
                            $reporte->origen,
                            $reporte->coordenada_x,
                            $reporte->coordenada_y,
                            $reporte->temperatura,
                            $reporte->viento,
                            $reporte->humedad,
                            $reporte->especies->grupo->nombre ?? '',
                            $reporte->especies->nombre ?? '',
                            $reporte->atractivo->nombre ?? '',
                            $reporte->visto,
                            $reporte->dispersados,
                            $reporte->sacrificados,
                            '', // Herramienta
                            '', // Acción
                            '', // Cantidad
                            $reporte->comentarios,
                            $reporte->created_at ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i A') : '',
                            // Actualización
                            $actualizacion->created_at ? Carbon::parse($actualizacion->created_at)->format('Y-m-d h:i A') : '',
                            $actualizacion->user->name ?? 'N/A',
                            $actualizacion->actualizacion ?? '',
                        ], null, "A$row");

                        $row++;
                    }
                } else {
                    // Sin munición ni actualizaciones, solo una fila con datos reporte
                    $sheet->fromArray([
                        $reporte->id,
                        $reporte->user->name ?? 'N/A',
                        $reporte->tipo_evento,
                        $reporte->origen,
                        $reporte->coordenada_x,
                        $reporte->coordenada_y,
                        $reporte->temperatura,
                        $reporte->viento,
                        $reporte->humedad,
                        $reporte->especies->grupo->nombre ?? '',
                        $reporte->especies->nombre ?? '',
                        $reporte->atractivo->nombre ?? '',
                        $reporte->visto,
                        $reporte->dispersados,
                        $reporte->sacrificados,
                        '', // Herramienta
                        '', // Acción
                        '', // Cantidad
                        $reporte->comentarios,
                        $reporte->created_at ? Carbon::parse($reporte->created_at)->format('Y-m-d h:i A') : '',
                        '', '', '', // Sin actualizaciones
                    ], null, "A$row");

                    $row++;
                }
            }
        }

        $fileName = 'Reporte_Evento_Intervenciones.xlsx';
        $tempFilePath = storage_path("app/public/{$fileName}"); // ruta para guardar temporalmente

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFilePath);

        return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
    }),

        ];
    }

    public function getTitle(): string
    {
        return 'Reportes Evento Intervenciones'; // título
    }
}
