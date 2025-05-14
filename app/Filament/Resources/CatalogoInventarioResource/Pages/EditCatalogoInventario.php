<?php

namespace App\Filament\Resources\CatalogoInventarioResource\Pages;

use App\Filament\Resources\CatalogoInventarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatalogoInventario extends EditRecord
{
    protected static string $resource = CatalogoInventarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
