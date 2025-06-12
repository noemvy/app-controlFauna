<?php

namespace App\Filament\Resources\DepartamentoResource\Pages;

use App\Filament\Resources\DepartamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartamento extends CreateRecord
{
    protected static string $resource = DepartamentoResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Solo muestra el botón "Crear"
            $this->getCancelFormAction(), // Muestra el botón "Cancelar"
        ];
    }
}
