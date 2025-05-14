<?php

namespace App\Filament\Resources\CatalogoInventarioResource\Pages;

use App\Filament\Resources\CatalogoInventarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatalogoInventarios extends ListRecords
{
    protected static string $resource = CatalogoInventarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
