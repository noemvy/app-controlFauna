<?php

namespace App\Filament\Resources\PatrullajeResource\Pages;

use App\Filament\Resources\PatrullajeResource;
use App\Models\Patrullaje;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Redirect;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class CreatePatrullaje extends Page
{
    protected static string $resource = PatrullajeResource::class;
    protected static string $view = 'filament.resources.patrullaje-resource.pages.auto-create';

    public function mount()
{
    if (!Filament::auth()->check()) {
        return redirect()->route('filament.auth.login');
    }

    $user = Filament::auth()->user();

    $patrullajeEnProceso = Patrullaje::where('user_id', $user->id)
        ->where('estado', 'en_proceso')
        ->latest()
        ->first();

    if ($patrullajeEnProceso) {
        if (!Patrullaje::find($patrullajeEnProceso->id)) {
            // Si fue eliminado, continuar y crear uno nuevo
        } else {
            Notification::make()
                ->title('Tienes un patrullaje en proceso')
                ->body('Completalo para poder crear un nuevo patrullaje')
                ->warning()
                ->send();

            return $this->redirectRoute('filament.dashboard.resources.patrullajes.edit', [
                'record' => $patrullajeEnProceso->id,
            ]);
        }
    }

    if (session()->has('just_created_patrullaje_id')) {
        $id = session()->pull('just_created_patrullaje_id');
        if (Patrullaje::find($id)) {
            return $this->redirectRoute('filament.dashboard.resources.patrullajes.edit', [
                'record' => $id,
            ]);
        }
        // Si no existe el patrullaje se crea uno nuevo.
    }

    $nuevoPatrullaje = Patrullaje::create([
        'aerodromo_id' => $user->aerodromo_id,
        'user_id' => $user->id,
        'estado' => 'en_proceso',
        'inicio' => Carbon::now('America/Panama'),
        'fin' => '',
    ]);

    session()->put('just_created_patrullaje_id', $nuevoPatrullaje->id);

    return $this->redirectRoute('filament.dashboard.resources.patrullajes.edit', [
        'record' => $nuevoPatrullaje->id,
    ]);
}

}
