<?php

namespace App\Filament\Resources\InventarioMunicionesResource\Pages;

use App\Filament\Resources\InventarioMunicionesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventarioMuniciones extends ListRecords
{
    protected static string $resource = InventarioMunicionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
