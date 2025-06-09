<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatrullajeResource\Pages;
use App\Models\Patrullaje;
use App\Models\User;
use App\Models\Aerodromo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions;
use Carbon\Carbon;

class PatrullajeResource extends Resource
{
    protected static ?string $model = Patrullaje::class;

    protected static ?string $navigationIcon = 'lucide-car-front';
    protected static ?string $navigationGroup = 'Patrullajes';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
    return $form
    ->schema([
    Forms\Components\Select::make('aerodromo_id')
        ->label('Aeropuerto')->options(Aerodromo::pluck('nombre', 'id'))
        ->required()->default(Filament::auth()->user()->aerodromo_id)
        ->disabled()->dehydrated(true),
    Forms\Components\Select::make('user_id')
        ->label('Usuario')->options(User::pluck('name', 'id'))
        ->required()->default(Filament::auth()->id())
        ->disabled()->dehydrated(true),
    Forms\Components\Select::make('estado')
        ->label('Estado')
        ->options([
            'en_proceso' => '🟢En Proceso',
            'finalizado' => '🔴Finalizado',
        ])
        ->required()->default('en_proceso')
        ->disabled()->dehydrated(true)->reactive(),
    Forms\Components\TextInput::make('inicio')
        ->label('Inicio')->default(Carbon::now('America/Panama')->format('Y-m-d H:i:s'))
        ->required()->disabled()->dehydrated(true),
    Forms\Components\TextArea::make('comentarios')
        ->label('Comentarios')->maxLength(250)->columnSpanFull(),
    Forms\Components\Section::make('Acciones')
        ->schema([
        Actions::make([
        Action::make('agregar_intervencion')
        ->label('Nueva Intervención')->url(route('filament.dashboard.resources.intervenciones-drafts.create', ['returnTo' => 'patrullaje']))
        ->icon('heroicon-o-plus')->color('success'),
            ]),
    Forms\Components\Placeholder::make('conteoIntervenciones')
        ->label('')
        ->content(function () {
            $userId = Filament::auth()->id();
            $count = \App\Models\IntervencionesDraft::where('user_id', $userId)->count();
            return "Total: {$count} intervención(es) creadas";
        }),
    ]),
]);
    }

public static function table(Table $table): Table
    {
    return $table
    ->columns([
        Tables\Columns\TextColumn::make('user.name')->label('Usuario'),
        Tables\Columns\TextColumn::make('inicio')->label('Hora de Inicio'),
        Tables\Columns\TextColumn::make('fin')->label('Hora de Finalización'),
    ])
    ->defaultSort('created_at', 'desc')
    ->actions([
        Tables\Actions\Action::make('ver_detalles')
        ->label('Ver Detalles')
        ->icon('heroicon-o-eye')
        ->modalHeading('Detalles del Patrullaje')
        ->modalSubmitAction(false)
        ->modalCancelActionLabel('Cerrar')
        ->modalContent(function ($record) {
            return view('components.patrullaje-detalles', compact('record'));
        }),

    ])
    ->filters([
                // Filtros opcionales
    ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatrullajes::route('/'),
            'create' => Pages\CreatePatrullaje::route('/create'),
            'edit' => Pages\EditPatrullaje::route('/{record}/edit'),
        ];
    }
}
