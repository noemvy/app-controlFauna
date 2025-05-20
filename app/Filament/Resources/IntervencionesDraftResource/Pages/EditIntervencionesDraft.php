<?php

namespace App\Filament\Resources\IntervencionesDraftResource\Pages;

use App\Filament\Resources\IntervencionesDraftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntervencionesDraft extends EditRecord
{
    protected static string $resource = IntervencionesDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
