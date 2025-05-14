<?php

namespace App\Filament\Resources\FabricanteAeronaveResource\Pages;

use App\Filament\Resources\FabricanteAeronaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFabricanteAeronaves extends ListRecords
{
    protected static string $resource = FabricanteAeronaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
