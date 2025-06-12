<?php

namespace App\Filament\Resources\PiezaAvionResource\Pages;

use App\Filament\Resources\PiezaAvionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePiezaAvion extends CreateRecord
{
    protected static string $resource = PiezaAvionResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
