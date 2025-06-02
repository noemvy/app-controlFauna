<?php

namespace App\Filament\Resources\PatrullajeResource\Pages;

use App\Filament\Resources\PatrullajeResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use App\Models\IntervencionesDraft;
use App\Models\Intervenciones;
use App\Models\InventarioMuniciones;
use App\Models\PivotePatrullajeIntervencion;
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
        $this->record->update([
            'fin' => Carbon::now('America/Panama'),
            'estado' => 'finalizado',
        ]);

        $usuarioId = Filament::auth()->id();
        $drafts = IntervencionesDraft::where('user_id', $usuarioId)->get();

        foreach ($drafts as $draft) {
            $data = $draft->only([
                'especies_id', 'catinventario_id', 'acciones_id', 'cantidad_utilizada', 'atractivos_id',
                'vistos', 'sacrificados', 'dispersados', 'coordenada_x', 'coordenada_y', 'temperatura', 'viento',
                'humedad', 'fotos', 'comentarios', 'municion_utilizada'
            ]);
            $data['patrullaje_id'] = $this->record->id;

            // Crear la intervención final
            $intervencionFinal = Intervenciones::create($data);

            // Actualizar los registros pivote: asignar intervencion_id y poner intervencion_draft_id en null
            PivotePatrullajeIntervencion::where('intervencion_draft_id', $draft->id)
                ->update([
                    'intervencion_id' => $intervencionFinal->id,
                    'intervencion_draft_id' => null,
                ]);

            // Eliminar el draft
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

        // Obtener drafts del usuario para este patrullaje
        $drafts = IntervencionesDraft::where('user_id', $usuario->id)->get();

        foreach ($drafts as $draft) {
            // Obtener pivotes asociados al draft
            $pivotes = PivotePatrullajeIntervencion::where('intervencion_draft_id', $draft->id)->get();

            // Restaurar stock sumando cantidad utilizada en cada pivote
            foreach ($pivotes as $pivote) {
                $inventario = InventarioMuniciones::where('catinventario_id', $pivote->catinventario_id)
                    ->where('aerodromo_id', $aerodromoId)
                    ->first();

                if ($inventario) {
                    $inventario->cantidad_actual += $pivote->cantidad_utilizada;
                    $inventario->save();
                }
            }

            // Borrar pivotes asociados
            PivotePatrullajeIntervencion::where('intervencion_draft_id', $draft->id)->delete();

            // Borrar draft
            $draft->delete();
        }

        // Finalmente eliminar el patrullaje
        $this->record->delete();

        Notification::make()
            ->title('Patrullaje Cancelado y stock restaurado')
            ->warning()
            ->send();

        return redirect(static::getResource()::getUrl('index'));
    }),

        ];
    }
}
