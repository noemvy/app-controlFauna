<?php

namespace App\Filament\Resources\ModeloAeronavesResource\Pages;

use App\Filament\Resources\ModeloAeronavesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateModeloAeronaves extends CreateRecord
{
    protected static string $resource = ModeloAeronavesResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
