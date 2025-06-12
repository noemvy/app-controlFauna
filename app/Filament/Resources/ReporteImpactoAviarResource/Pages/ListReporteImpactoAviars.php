<?php

namespace App\Filament\Resources\ReporteImpactoAviarResource\Pages;

use App\Filament\Resources\ReporteImpactoAviarResource;
use App\Models\Aerodromo;
use App\Models\ReporteImpactoAviar;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Filament\Forms;

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
            Actions\Action::make('exportReports')
            ->label('Descargar Excel')
            ->icon('lucide-file-x-2')
            ->color('info')
            ->form([
        Forms\Components\Select::make('aerodromo_id')
            ->label('Aeródromo')
            ->options(Aerodromo::pluck('nombre', 'id'))
            ->searchable()
            ->placeholder('Todos los aeródromos')
            ->reactive(),

        Forms\Components\DatePicker::make('fecha_inicio')
            ->label('Fecha de inicio')
            ->placeholder('Desde...'),

        Forms\Components\DatePicker::make('fecha_fin')
            ->label('Fecha fin')
            ->placeholder('Hasta...'),
    ])
    ->action(function (array $data) {
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
            'Fecha Actualización',
            'Autor Actualización',
            'Contenido Actualización',
        ];
        $sheet->fromArray([$headers], null, 'A1');

        // Filtro base
        $query = ReporteImpactoAviar::with([
            'aerodromo',
            'pista',
            'aerolinea',
            'modelo',
            'especie',
            'partesGolpeadas',
            'partesDanadas',
            'user',
            'actualizaciones',
        ]);

        // Filtro por aeródromo
        if (!empty($data['aerodromo_id'])) {
            $query->where('aerodromo_id', $data['aerodromo_id']);
        }

        // Filtro por rango de fechas
        if (!empty($data['fecha_inicio'])) {
            $query->whereDate('fecha', '>=', $data['fecha_inicio']);
        }
        if (!empty($data['fecha_fin'])) {
            $query->whereDate('fecha', '<=', $data['fecha_fin']);
        }

        $reportes = $query->get();
        if ($reportes->isEmpty()) {
        \Filament\Notifications\Notification::make()
            ->title('Sin resultados')
            ->body('No hay datos disponibles para descargar')
            ->warning()
            ->send();

        return;
    }
        $row = 2;

        foreach ($reportes as $reporte) {
            $partesGolpeadas = $reporte->partesGolpeadas->pluck('nombre')->implode(', ') ?: 'N/A';
            $partesDanadas = $reporte->partesDanadas->pluck('nombre')->implode(', ') ?: 'N/A';

            if ($reporte->actualizaciones->isNotEmpty()) {
                foreach ($reporte->actualizaciones as $actualizacion) {
                    $sheet->fromArray([
                        $reporte->codigo,
                        $reporte->aerodromo->codigo ?? '',
                        $reporte->pista->nombre ?? '',
                        !empty($reporte->fecha) ? Carbon::parse($reporte->fecha)->format('Y-m-d h:i A') : '',
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
                        Carbon::parse($actualizacion->created_at)->format('Y-m-d h:i A'),
                        $actualizacion->user->name ?? 'N/A',
                        $actualizacion->actualizacion ?? '',
                    ], null, "A$row");
                    $row++;
                }
            } else {
                $sheet->fromArray([
                    $reporte->codigo,
                    $reporte->aerodromo->codigo ?? '',
                    $reporte->pista->nombre ?? '',
                    !empty($reporte->fecha) ? Carbon::parse($reporte->fecha)->format('Y-m-d h:i A') : '',
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
                    '', '', '', // Sin actualizaciones
                ], null, "A$row");
                $row++;
            }
        }

        // Guardar temporalmente
        $fileName = 'Reportes_Impacto_Fauna_' . now()->format('Ymd_His') . '.xlsx';
        $tempFilePath = Storage::path($fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFilePath);

        return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
    }),


        ];
    }


}
