<?php

namespace App\Filament\Resources\AccionesResource\Pages;

use App\Filament\Resources\AccionesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcciones extends ListRecords
{
    protected static string $resource = AccionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
