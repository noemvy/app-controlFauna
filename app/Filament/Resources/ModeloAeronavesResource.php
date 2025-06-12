<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModeloAeronavesResource\Pages;
use App\Filament\Resources\ModeloAeronavesResource\RelationManagers;
use App\Models\ModeloAeronave;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModeloAeronavesResource extends Resource
{
    protected static ?string $model = ModeloAeronave::class;

    protected static ?string $navigationLabel = 'Modelos de Aeronaves';
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Catálogos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('modelo')
                    ->label('Modelo')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('fabricante_id')
                    ->label('Fabricante')
                    ->relationship('fabricante', 'nombre', function ($query) {
                        $query->orderBy('id', 'asc');
                    })
                    ->required(),

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
                Tables\Columns\TextColumn::make('modelo')
                    ->label('Modelo')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fabricante.nombre')
                    ->label('Fabricante')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('estado')
                    ->label('Activo')
                    ->boolean() // Configura el comportamiento booleano
                    ->trueIcon('heroicon-o-check-circle') // Ícono para verdadero
                    ->falseIcon('heroicon-o-x-circle') // Ícono para falso
                    ->trueColor('success') // Color para verdadero
                    ->falseColor('danger'), // Color para falso
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
            'index' => Pages\ListModeloAeronaves::route('/'),
            'create' => Pages\CreateModeloAeronaves::route('/create'),
            'edit' => Pages\EditModeloAeronaves::route('/{record}/edit'),
        ];
    }
}
