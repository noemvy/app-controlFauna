<?php

namespace App\Filament\Resources\IntervencionesResource\Pages;

use App\Filament\Resources\IntervencionesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntervenciones extends ListRecords
{
    protected static string $resource = IntervencionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
