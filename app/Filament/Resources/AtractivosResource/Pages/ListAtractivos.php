<?php

namespace App\Filament\Resources\AtractivosResource\Pages;

use App\Filament\Resources\AtractivosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAtractivos extends ListRecords
{
    protected static string $resource = AtractivosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
