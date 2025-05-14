<?php

namespace App\Filament\Resources\AerodromoResource\Pages;

use App\Filament\Resources\AerodromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAerodromos extends ListRecords
{
    protected static string $resource = AerodromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
