<?php
namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Patrullaje; // Modelo Patrullaje
use App\Models\Aerodromo; // Modelo Aerodromo
use App\Models\User; // Modelo User

class PatrullajeResource extends Resource
{
    protected static ?string $model = Patrullaje::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Patrullajes';
    protected static ?string $navigationGroup = 'Operaciones'; // Agrupamos en el grupo Operaciones

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
                ->options(User::all()->pluck('name', 'id'))
                ->required(),

            // Inicio del patrullaje
            Forms\Components\TextInput::make('inicio')
                ->label('Inicio')
                ->required(),

            // Fin del patrullaje
            Forms\Components\TextInput::make('fin')
                ->label('Fin')
                ->required(),

            // Fecha de creación (automáticamente gestionada por Laravel)
            Forms\Components\DateTimePicker::make('created_at')
                ->label('Fecha de Patrullaje')
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

                Tables\Columns\TextColumn::make('inicio')
                    ->label('Inicio')
                    ->searchable(),

                Tables\Columns\TextColumn::make('fin')
                    ->label('Fin')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Patrullaje')
                    ->sortable()
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                // Filtros adicionales si es necesario
            ])
            ->actions([
                // Acciones personalizadas, como ver detalles
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Acciones masivas si es necesario
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PatrullajeResource\Pages\ListPatrullajes::route('/'),
            'create' => \App\Filament\Resources\PatrullajeResource\Pages\CreatePatrullaje::route('/create'),
            'edit' => \App\Filament\Resources\PatrullajeResource\Pages\EditPatrullaje::route('/{record}/edit'),
        ];
    }
}
