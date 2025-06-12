<?php

namespace App\Filament\Resources\EspeciesResource\Pages;

use App\Filament\Resources\EspeciesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEspecies extends EditRecord
{
    protected static string $resource = EspeciesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
