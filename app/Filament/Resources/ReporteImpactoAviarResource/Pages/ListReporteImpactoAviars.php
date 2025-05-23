<?php

namespace App\Filament\Resources\ReporteImpactoAviarResource\Pages;

use App\Filament\Resources\ReporteImpactoAviarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReporteImpactoAviars extends ListRecords
{
    protected static string $resource = ReporteImpactoAviarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('Nuevo Reporte')
            ->label('Nuevo Reporte'),
        ];
    }
}
