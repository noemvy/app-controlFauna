<?php

namespace App\Filament\Resources\AccionesResource\Pages;

use App\Filament\Resources\AccionesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcciones extends EditRecord
{
    protected static string $resource = AccionesResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
