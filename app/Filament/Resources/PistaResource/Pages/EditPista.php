<?php

namespace App\Filament\Resources\PistaResource\Pages;

use App\Filament\Resources\PistaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPista extends EditRecord
{
    protected static string $resource = PistaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
