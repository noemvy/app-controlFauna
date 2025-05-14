<?php

namespace App\Filament\Resources\PiezaAvionResource\Pages;

use App\Filament\Resources\PiezaAvionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPiezaAvions extends ListRecords
{
    protected static string $resource = PiezaAvionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
