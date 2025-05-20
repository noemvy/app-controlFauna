<?php

namespace App\Filament\Resources\IntervencionesDraftResource\Pages;

use App\Filament\Resources\IntervencionesDraftResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use App\Models\IntervencionesDraft;
use App\Models\InventarioMuniciones;

class CreateIntervencionesDraft extends CreateRecord
{
    protected static string $resource = IntervencionesDraftResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = Filament::auth()->id();

    // Tomar el primer elemento del repeater "municion_utilizada"
    $repeaterData = $data['municion_utilizada'][0] ?? null;

    if ($repeaterData) {
        $data['catinventario_id'] = $repeaterData['catinventario_id'];
        $data['acciones_id'] = $repeaterData['acciones_id'];
        // Si quieres guardar la cantidad como campo separado
        $data['cantidad_usada'] = $repeaterData['cantidad_utilizada'] ?? null;
    }

    return $data;
}


    protected function afterCreate(): void
    {
        $intervencion = $this->record;
        $usuario = Filament::auth()->user();
        $aerodromoId = $usuario->aerodromo_id;

        foreach ($intervencion->municion_utilizada as $item) {
            $catId = $item['catinventario_id'];
            $cantidad = (int) $item['cantidad_utilizada'];

            $inventario = InventarioMuniciones::where('catinventario_id', $catId)
                ->where('aerodromo_id', $aerodromoId)
                ->first();

            if (!$inventario) {
                Notification::make()
                    ->title("No hay inventario registrado para esa munición.")
                    ->danger()
                    ->send();
                return;
            }

            if ((int) $inventario->cantidad_actual < $cantidad) {
                Notification::make()
                    ->title("Cantidad insuficiente de '{$inventario->catalogoInventario->nombre}'")
                    ->danger()
                    ->send();
                return;
            }

            // Restar del inventario
            $inventario->cantidad_actual -= $cantidad;
            $inventario->save();
        }

        Notification::make()
            ->title("Intervención registrada y stock actualizado correctamente.")
            ->success()
            ->send();
    }

    function getRedirectUrl(): string
    {
        return route('filament.dashboard.resources.patrullajes.create');
    }
}
