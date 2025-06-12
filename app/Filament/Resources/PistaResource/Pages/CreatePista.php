<?php

namespace App\Filament\Resources\PistaResource\Pages;

use App\Filament\Resources\PistaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePista extends CreateRecord
{
    protected static string $resource = PistaResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
