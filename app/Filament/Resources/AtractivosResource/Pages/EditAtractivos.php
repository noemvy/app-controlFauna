<?php

namespace App\Filament\Resources\AtractivosResource\Pages;

use App\Filament\Resources\AtractivosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAtractivos extends EditRecord
{
    protected static string $resource = AtractivosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
