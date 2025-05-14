<?php

namespace App\Filament\Resources\AerodromoResource\Pages;

use App\Filament\Resources\AerodromoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAerodromo extends EditRecord
{
    protected static string $resource = AerodromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
