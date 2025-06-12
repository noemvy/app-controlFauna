<?php

namespace App\Filament\Resources\GruposResource\Pages;

use App\Filament\Resources\GruposResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGrupos extends CreateRecord
{
    protected static string $resource = GruposResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
