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
        // Si no hay sesión activa, salir
        if (!Filament::auth()->check()) {
            return redirect()->route('filament.auth.login');
        }

        $user = Filament::auth()->user();

        // Si ya existe un patrullaje en proceso, redirigir a ese
        $patrullajeEnProceso = Patrullaje::where('user_id', $user->id)
            ->where('estado', 'en_proceso')
            ->latest()
            ->first();
        //Alerta para avisar de que se debe finalizar el patrullaje para crear otro
        if ($patrullajeEnProceso) {
            Notification::make()
                ->title('Tienes un patrullaje en proceso')
                ->body('Completalo para poder crear un nuevo patrullaje')
                ->warning()
                ->send();

            return $this->redirectRoute('filament.dashboard.resources.patrullajes.edit', [
                'record' => $patrullajeEnProceso->id,
            ]);
        }

        // Si ya se había creado uno en esta sesión, redirigir sin volver a crear
        if (session()->has('just_created_patrullaje_id')) {
            $id = session()->pull('just_created_patrullaje_id');
            return $this->redirectRoute('filament.dashboard.resources.patrullajes.edit', [
                'record' => $id,
            ]);
        }

        // Aqui se crea  un nuevo patrullaje
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
