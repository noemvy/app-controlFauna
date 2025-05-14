<?php

namespace App\Filament\Resources\AerolineasResource\Pages;

use App\Filament\Resources\AerolineasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAerolineas extends EditRecord
{
    protected static string $resource = AerolineasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
