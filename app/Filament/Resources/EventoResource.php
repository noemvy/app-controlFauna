<?php

namespace App\Filament\Resources;

use App\Models\Evento; // Asegúrate de usar el modelo Evento
use App\Models\Aerodromo; // Asegúrate de tener el modelo Aerodromo
use App\Models\User; // Asegúrate de tener el modelo User
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Facades\Filament;

class EventoResource extends Resource
{
    protected static ?string $model = Evento::class;
    protected static ?string $navigationIcon = 'lucide-radio-tower';
     protected static ?string $navigationLabel = 'Eventos';

    // Añadir el grupo de navegación "Operaciones"
    protected static ?string $navigationGroup = 'Operaciones';


    public static function form(Form $form): Form
    {
        return $form->schema([
            // Selección del aeródromo
            Forms\Components\Select::make('aerodromo_id')
                ->label('Aeródromo')
                ->options(Aerodromo::all()->pluck('nombre', 'id'))
                ->required(),

            // Selección del usuario
            Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->options(User::pluck('name', 'id'))
                ->required()
                ->default(Filament::auth()->id())
                ->disabled()
                ->dehydrated(true),

            // Tipo de evento
            Forms\Components\TextInput::make('tipo_evento')
                ->label('Tipo de Evento')
                ->required(),

            // Comentario
            Forms\Components\Textarea::make('comentario')
                ->label('Comentario')
                ->required(),

            // Fecha de creación (automáticamente gestionada por Laravel)
            Forms\Components\DateTimePicker::make('created_at')
                ->label('Fecha de Evento')
                ->required()
                ->default(now())
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Definimos las columnas que se mostrarán en la tabla
                Tables\Columns\TextColumn::make('aerodromo.nombre')
                    ->label('Aeródromo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tipo_evento')
                    ->label('Tipo de Evento')
                    ->searchable(),

                Tables\Columns\TextColumn::make('comentario')
                    ->label('Comentario')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Evento')
                    ->sortable()
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                // Filtros adicionales si es necesario
            ])
            ->actions([
                // Acción de edición para los eventos
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Acciones masivas si es necesario
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\EventoResource\Pages\ListEventos::route('/'),
            'create' => \App\Filament\Resources\EventoResource\Pages\CreateEvento::route('/create'),
            'edit' => \App\Filament\Resources\EventoResource\Pages\EditEvento::route('/{record}/edit'),
        ];
    }
}
