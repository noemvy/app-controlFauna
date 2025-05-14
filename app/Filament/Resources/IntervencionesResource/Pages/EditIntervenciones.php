<?php

namespace App\Filament\Resources\IntervencionesResource\Pages;

use App\Filament\Resources\IntervencionesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntervenciones extends EditRecord
{
    protected static string $resource = IntervencionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
