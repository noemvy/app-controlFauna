<?php

namespace App\Filament\Resources\FabricanteAeronaveResource\Pages;

use App\Filament\Resources\FabricanteAeronaveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFabricanteAeronave extends EditRecord
{
    protected static string $resource = FabricanteAeronaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
