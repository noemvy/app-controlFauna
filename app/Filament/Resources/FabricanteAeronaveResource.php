<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FabricanteAeronaveResource\Pages;
use App\Filament\Resources\FabricanteAeronaveResource\RelationManagers;
use App\Models\FabricanteAeronave;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FabricanteAeronaveResource extends Resource
{
    protected static ?string $model = FabricanteAeronave::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationLabel = 'Fabricante de Aeronave';
    protected static ?string $navigationGroup = 'Catálogos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ])
                    ->default(1) // Valor por defecto establecido como "Activo"
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
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
                //
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
            'index' => Pages\ListFabricanteAeronaves::route('/'),
            'create' => Pages\CreateFabricanteAeronave::route('/create'),
            'edit' => Pages\EditFabricanteAeronave::route('/{record}/edit'),
        ];
    }
}
