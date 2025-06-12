<?php

namespace App\Filament\Resources\EspeciesResource\Pages;

use App\Filament\Resources\EspeciesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEspecies extends ListRecords
{
    protected static string $resource = EspeciesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
