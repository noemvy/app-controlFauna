<?php

namespace App\Filament\Resources\AtractivosResource\Pages;

use App\Filament\Resources\AtractivosResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAtractivos extends CreateRecord
{
    protected static string $resource = AtractivosResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
