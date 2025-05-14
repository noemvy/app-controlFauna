<?php

namespace App\Filament\Resources\InventarioMunicionesResource\Pages;

use App\Filament\Resources\InventarioMunicionesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventarioMuniciones extends EditRecord
{
    protected static string $resource = InventarioMunicionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
