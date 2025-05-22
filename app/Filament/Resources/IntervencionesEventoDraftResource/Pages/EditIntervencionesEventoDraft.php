<?php

namespace App\Filament\Resources\IntervencionesEventoDraftResource\Pages;

use App\Filament\Resources\IntervencionesEventoDraftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntervencionesEventoDraft extends EditRecord
{
    protected static string $resource = IntervencionesEventoDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
