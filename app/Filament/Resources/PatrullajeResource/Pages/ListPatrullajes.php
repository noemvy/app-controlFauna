<?php

namespace App\Filament\Resources\PatrullajeResource\Pages;

use App\Filament\Resources\PatrullajeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatrullajes extends ListRecords
{
    protected static string $resource = PatrullajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
