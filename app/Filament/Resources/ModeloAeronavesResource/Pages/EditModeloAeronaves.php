<?php

namespace App\Filament\Resources\ModeloAeronavesResource\Pages;

use App\Filament\Resources\ModeloAeronavesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModeloAeronaves extends EditRecord
{
    protected static string $resource = ModeloAeronavesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
