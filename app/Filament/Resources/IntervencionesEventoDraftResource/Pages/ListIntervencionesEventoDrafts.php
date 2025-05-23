<?php

namespace App\Filament\Resources\IntervencionesEventoDraftResource\Pages;

use App\Filament\Resources\IntervencionesEventoDraftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntervencionesEventoDrafts extends ListRecords
{
    protected static string $resource = IntervencionesEventoDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            /*----------------------------BOTON DE NUEVA INTERVENCION--------------------------------*/
            Actions\CreateAction::make('Nueva intervención')
            ->label('Nueva Interveción'),
        ];
    }
}
