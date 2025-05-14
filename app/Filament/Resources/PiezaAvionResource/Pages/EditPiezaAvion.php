<?php

namespace App\Filament\Resources\PiezaAvionResource\Pages;

use App\Filament\Resources\PiezaAvionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPiezaAvion extends EditRecord
{
    protected static string $resource = PiezaAvionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
