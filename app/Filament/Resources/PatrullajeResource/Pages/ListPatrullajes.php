<?php

namespace App\Filament\Resources\PatrullajeResource\Pages;

use App\Filament\Resources\PatrullajeResource;
use App\Models\Patrullaje;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ListPatrullajes extends ListRecords
{
    protected static string $resource = PatrullajeResource::class;

    protected function getHeaderActions(): array
    {
    return [
        // Botón de crear patrullaje
        Actions\CreateAction::make(),
         // Botón de generar Excel
        Action::make('exportReports')
        ->label('Descargar Excel')
        ->icon('lucide-file-x-2')
        ->color('info')
        ->action(function () {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Código', 'Aeropuerto', 'Usuario', 'Estado', 'Inicio', 'Fin', 'Duración', 'Comentarios', 'N°Intervenciones',
            'Vistos', 'Dispersados', 'Sacrificados',
        ];
        $sheet->fromArray([$headers], null, 'A1');
        // Obtener patrullajes con relaciones
        $reportes = Patrullaje::with([
            'aerodromo',
            'user',
            'intervenciones',
        ])->get();
        //Alerta si no hay datos.
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
        $intervenciones = $reporte->intervenciones;
        //Variable para guardar el total de duracion del patrullaje.
        $duracion = '-';
        if ($reporte->inicio && $reporte->fin) {
            $duracion = Carbon::parse($reporte->inicio)->diff(Carbon::parse($reporte->fin))->format('%H:%I:%S');
        }
        $sheet->fromArray([
        $reporte->id,
        $reporte->aerodromo->nombre,
        $reporte->user->name ,
        $reporte->estado,
        $reporte->inicio,
        $reporte->fin,
        $duracion ?? '-',
        $reporte->comentarios ?? '-',
        $intervenciones->count(),
        $intervenciones->sum('vistos') ?? 0,
        $intervenciones->sum('dispersados') ?? 0,
        $intervenciones->sum('sacrificados') ?? 0,
        ], null, "A$row");
        $row++;
        }
        $fileName = 'Reportes_Patrullaje.xlsx';
        $tempFilePath = storage_path("app/public/{$fileName}");

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFilePath);

        return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
        }),
    ];
}

    public function getTitle(): string
    {
        return 'Reportes Patrullajes';
    }
}
