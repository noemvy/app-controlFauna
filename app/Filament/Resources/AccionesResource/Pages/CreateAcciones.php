<?php

namespace App\Filament\Resources\AccionesResource\Pages;

use App\Filament\Resources\AccionesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAcciones extends CreateRecord
{
    protected static string $resource = AccionesResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
