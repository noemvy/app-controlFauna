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

                    $drafts = IntervencionesDraft::where('user_id', Filament::auth()->id())->get();

                    foreach ($drafts as $draft) {
                    $data = $draft->only([
                        'especies_id', 'catinventario_id', 'acciones_id', 'atractivos_id',
                        'vistos', 'sacrificados', 'dispersados', 'coordenada_x', 'coordenada_y',
                        'temperatura', 'viento', 'humedad', 'fotos', 'comentarios'
                    ]);

    // Aquí le asignas el patrullaje_id
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
        ];
    }
}

