<?php

namespace App\Filament\Resources\GruposResource\Pages;

use App\Filament\Resources\GruposResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrupos extends ListRecords
{
    protected static string $resource = GruposResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
