<?php
/*-----------------------------------LOGICA PARA GUARDAR LAS INTERVENCIONES DE EVENTOS------------------------ */

namespace App\Filament\Resources\IntervencionesEventoDraftResource\Pages;

use App\Filament\Resources\IntervencionesEventoDraftResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use App\Models\InventarioMuniciones;
use App\Models\PivoteEvento;


class CreateIntervencionesEventoDraft extends CreateRecord
{
    protected static string $resource = IntervencionesEventoDraftResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }

    protected function beforeCreate(): void
    {
        $data = $this->form->getState();
        $usuario = Filament::auth()->user();
        $aerodromoId = $usuario->aerodromo_id;

        $municiones = $data['municion_utilizada'] ?? [];

        foreach ($municiones as $item) {
            $catId = $item['catinventario_id'] ?? null;
            $cantidad = (int) ($item['cantidad_utilizada'] ?? 0);

            $inventario = InventarioMuniciones::where('catinventario_id', $catId)
                ->where('aerodromo_id', $aerodromoId)
                ->first();

            if (!$inventario) {
                Notification::make()
                    ->title("No hay inventario registrado para la herramienta seleccionada.")
                    ->danger()
                    ->send();

                $this->halt();
                return;
            }

            if ($inventario->cantidad_actual < $cantidad) {
                Notification::make()
                    ->title("Stock insuficiente de '{$inventario->catalogoInventario->nombre}'. Solo hay {$inventario->cantidad_actual}.")
                    ->danger()
                    ->send();

                $this->halt();
                return;
            }
        }
    }

    protected function afterCreate(): void
    {
        $intervencion = $this->record;
        $usuario = Filament::auth()->user();
        $aerodromoId = $usuario->aerodromo_id;
        $municiones = $this->form->getState()['municion_utilizada'] ?? [];


        foreach ($municiones as $item) {
            $catId = $item['catinventario_id'];
            $accionId = $item['acciones_id'];
            $cantidad = (int) $item['cantidad_utilizada'];

            //Descontar del inventario
            $inventario = InventarioMuniciones::where('catinventario_id', $catId)
                ->where('aerodromo_id', $aerodromoId)
                ->first();

            if ($inventario) {
                $inventario->cantidad_actual -= $cantidad;
                $inventario->save();
            }

            // Guardar en tabla pivote
            PivoteEvento::create([
                'intervencion_id'=> $intervencion->id,
                'catinventario_id' => $catId,
                'acciones_id' => $accionId,
                'cantidad_utilizada' => $cantidad,
            ]);
        }

        Notification::make()
            ->title("Intervención registrada y stock actualizado correctamente.")
            ->success()
            ->send();
    }

    function getRedirectUrl(): string
    {
        return route('filament.dashboard.resources.intervenciones-evento-drafts.index');
    }



}
