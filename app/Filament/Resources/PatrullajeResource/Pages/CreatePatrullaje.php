<?php

namespace App\Filament\Resources\PatrullajeResource\Pages;

use App\Filament\Resources\PatrullajeResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use Filament\Facades\Filament;
use App\Models\IntervencionesDraft;
use App\Models\Intervenciones;
use App\Models\InventarioMuniciones;

class CreatePatrullaje extends CreateRecord
{
    protected static string $resource = PatrullajeResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('finalizar')
                ->label('Finalizar Patrullaje')
                ->color('danger')
                ->action(function () {
                    // Crear el patrullaje
                    $data = $this->form->getState();
                    $data['fin'] = Carbon::now('America/Panama');
                    $this->record = $this->handleRecordCreation($data);

                    // Obtener borradores del usuario
                    $drafts = IntervencionesDraft::where('user_id', Filament::auth()->id())->get();

                    foreach ($drafts as $draft) {
                        $data = $draft->only([
                            'especies_id',
                            'catinventario_id',
                            'acciones_id',
                            'cantidad_utilizada',
                            'atractivos_id',
                            'vistos',
                            'sacrificados',
                            'dispersados',
                            'coordenada_x',
                            'coordenada_y',
                            'temperatura',
                            'viento',
                            'humedad',
                            'fotos',
                            'comentarios',
                            'municion_utilizada',
                        ]);

                        $data['patrullaje_id'] = $this->record->id;

                        Intervenciones::create($data);

                        $draft->delete();
                    }

                    Notification::make()
                        ->title('Patrullaje Finalizado')
                        ->success()
                        ->send();

                    return redirect(static::getResource()::getUrl('index'));
                }),

            Action::make('cancelar')
                ->label('Cancelar Patrullaje')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $usuario = Filament::auth()->user();
                    $aerodromoId = $usuario->aerodromo_id;

                    // Obtener borradores del usuario
                    $drafts = IntervencionesDraft::where('user_id', $usuario->id)->get();

                    foreach ($drafts as $draft) {
                        foreach ($draft->municion_utilizada ?? [] as $item) {
                            $catId = $item['catinventario_id'] ?? null;
                            $cantidad = (int) $item['cantidad_utilizada'] ?? 0;

                            if ($catId && $cantidad > 0 && $aerodromoId) {
                                $inventario = InventarioMuniciones::where('catinventario_id', $catId)
                                    ->where('aerodromo_id', $aerodromoId)
                                    ->first();

                                if ($inventario) {
                                    $inventario->cantidad_actual += $cantidad;
                                    $inventario->save();
                                }
                            }
                        }

                        $draft->delete();
                    }

                    Notification::make()
                        ->title('Patrullaje Cancelado y stock restaurado')
                        ->warning()
                        ->send();

                    return redirect(static::getResource()::getUrl('index'));
                }),
        ];
    }
}
