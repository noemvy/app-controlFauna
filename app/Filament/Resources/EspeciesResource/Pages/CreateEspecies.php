<?php

namespace App\Filament\Resources\EspeciesResource\Pages;

use App\Filament\Resources\EspeciesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEspecies extends CreateRecord
{
    protected static string $resource = EspeciesResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
