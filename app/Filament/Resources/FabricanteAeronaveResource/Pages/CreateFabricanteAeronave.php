<?php

namespace App\Filament\Resources\FabricanteAeronaveResource\Pages;

use App\Filament\Resources\FabricanteAeronaveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFabricanteAeronave extends CreateRecord
{
    protected static string $resource = FabricanteAeronaveResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
