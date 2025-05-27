<?php

namespace App\Filament\Resources\ReporteImpactoAviarResource\Pages;

use App\Filament\Resources\ReporteImpactoAviarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReporteImpactoAviar extends CreateRecord
{
    protected static string $resource = ReporteImpactoAviarResource::class;
    function getRedirectUrl(): string
    {
        return route('filament.dashboard.resources.reporte-impacto-aviars.index');
    }
}
