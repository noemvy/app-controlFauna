<?php

namespace App\Filament\Resources\PatrullajeResource\Pages;

use App\Filament\Resources\PatrullajeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use App\Models\IntervencionesDraft;
use App\Models\Intervenciones;
use App\Models\Patrullaje;
use App\Models\InventarioMuniciones;
use Carbon\Carbon;

class EditPatrullaje extends EditRecord
{
    protected static string $resource = PatrullajeResource::class;
 protected function getFormActions(): array
    {
        return [
            Action::make('finalizar')
                ->label('Finalizar Patrullaje')
                ->color('info')
                ->action(function () {
                    // Crear el patrullaje
                    $data = $this->form->getState();
                    $this->record->update([
                    'fin' => Carbon::now('America/Panama'),
                    'estado' => 'finalizado', // si deseas
                    ]);
                   // Obtener borradores del usuario
                    $drafts = IntervencionesDraft::where('user_id', Filament::auth()->id())->get();

                    foreach ($drafts as $draft) {
                        $data = $draft->only([
                            'especies_id','catinventario_id','acciones_id','cantidad_utilizada','atractivos_id',
                            'vistos','sacrificados','dispersados','coordenada_x','coordenada_y','temperatura','viento',
                            'humedad','fotos','comentarios','municion_utilizada',
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
            //Botón para cancelar el patrullaje
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
                      // Eliminar el patrullaje actual
                        $this->record->delete();
                    Notification::make()
                        ->title('Patrullaje Cancelado y stock restaurado')
                        ->warning()
                        ->send();
                        //Si se guarda o se cancela el patrullaje regresa a la pagina principal del patrullaje
                    return redirect(static::getResource()::getUrl('index'));
                }),
        ];
    }
}

