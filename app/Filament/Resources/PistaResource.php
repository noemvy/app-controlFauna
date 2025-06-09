<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PistaResource\Pages;
use App\Filament\Resources\PistaResource\RelationManagers;
use App\Models\Pista;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PistaResource extends Resource
{
    protected static ?string $model = Pista::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationLabel = 'Pistas de Aeropuertos';
    protected static ?string $navigationGroup = 'Catálogos';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('aerodromo_id')
                    ->label('Aeródromo')
                    ->relationship('aerodromo', 'nombre')
                    ->required(),

                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('codigo')
                    ->label('Código')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(65535),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ])
                    ->default(1) // Valor por defecto establecido como "Activo"
                    ->required(),

                Forms\Components\TextInput::make('autor')
                    ->label('Autor')
                    ->maxLength(255)
                    ->disabled() // Hace que el campo no sea editable
                    ->default(fn() => Auth::user()->name ?? 'Desconocido') // Rellena automáticamente con el nombre del usuario logueado o un valor por defecto
                    ->required(), // Si es obligatorio
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('codigo')->label('Código')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('descripcion')->label('Descripción')->limit(50),
                Tables\Columns\TextColumn::make('aerodromo.nombre')->label('Aeródromo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('autor')->label('Autor'),
                Tables\Columns\IconColumn::make('estado')
                    ->label('Activo')
                    ->boolean() // Configura el comportamiento booleano
                    ->trueIcon('heroicon-o-check-circle') // Ícono para verdadero
                    ->falseIcon('heroicon-o-x-circle') // Ícono para falso
                    ->trueColor('success') // Color para verdadero
                    ->falseColor('danger'), // Color para falso
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('aerodromo_id')
                    ->label('Aeródromo')
                    ->relationship('aerodromo', 'nombre'),

                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ]),
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
            'index' => Pages\ListPistas::route('/'),
            'create' => Pages\CreatePista::route('/create'),
            'edit' => Pages\EditPista::route('/{record}/edit'),
        ];
    }
}
