<?php

namespace App\Filament\Resources\AerolineasResource\Pages;

use App\Filament\Resources\AerolineasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAerolineas extends CreateRecord
{
    protected static string $resource = AerolineasResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
