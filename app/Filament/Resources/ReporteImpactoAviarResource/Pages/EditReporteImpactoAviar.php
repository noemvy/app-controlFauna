<?php

namespace App\Filament\Resources\ReporteImpactoAviarResource\Pages;

use App\Filament\Resources\ReporteImpactoAviarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReporteImpactoAviar extends EditRecord
{
    protected static string $resource = ReporteImpactoAviarResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
