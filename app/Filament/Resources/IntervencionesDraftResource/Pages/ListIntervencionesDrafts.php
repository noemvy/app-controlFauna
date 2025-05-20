<?php

namespace App\Filament\Resources\IntervencionesDraftResource\Pages;

use App\Filament\Resources\IntervencionesDraftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntervencionesDrafts extends ListRecords
{
    protected static string $resource = IntervencionesDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
