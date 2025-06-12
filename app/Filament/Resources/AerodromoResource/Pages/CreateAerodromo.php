<?php

namespace App\Filament\Resources\AerodromoResource\Pages;

use App\Filament\Resources\AerodromoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAerodromo extends CreateRecord
{
    protected static string $resource = AerodromoResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
