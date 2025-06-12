<?php

namespace App\Filament\Resources\DestinatarioResource\Pages;

use App\Filament\Resources\DestinatarioResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDestinatario extends CreateRecord
{
    protected static string $resource = DestinatarioResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
