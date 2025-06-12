<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogoInventarioResource\Pages;
use App\Models\CatalogoInventario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Acciones;


class CatalogoInventarioResource extends Resource
{
    protected static ?string $model = CatalogoInventario::class;

    protected static ?string $navigationIcon = 'lucide-square-pen';
    protected static ?string $navigationLabel = "Catálogo de Inventario";
    protected static ?string $navigationGroup = 'Inventario';
    protected static ?int $navigationSort = 999;

    public static function form(Form $form): Form
    {
    return $form
    ->schema([
    Forms\Components\Select::make('acciones_id')
        ->label('Acción')
        ->options(Acciones::all()->pluck('nombre', 'id'))
        ->searchable()
        ->required(),
    Forms\Components\TextInput::make('nombre')
        ->label('Nombre del equipo')
        ->placeholder('Escriba el nombre del equipo')
        ->required()
        ->maxLength(255),
    Forms\Components\Select::make('categoria_equipo')
        ->label('Categoria Equipo')
        ->options([
            'Armas' => 'Armas',
            'Municiones' => 'Municiones',
            'Instrumento' => 'Instrumento',
        ])
        ->required(),
    Forms\Components\Select::make('es_consumible')
        ->label('Tipo de Equipo')
        ->options([
            0 => 'No Consumible',
            1 => 'Consumible',
        ])
        ->default(1)
        ->required(),
    Forms\Components\TextInput::make('descripcion')
        ->label('Descripción del equipo')
        ->maxLength(200),
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
    Tables\Columns\TextColumn::make('nombre')->label('Nombre')
    ->searchable(),
    Tables\Columns\IconColumn::make('es_consumible')->label('Consumible')
    ->boolean()
        ->trueIcon('heroicon-o-check-circle') // Ícono para verdadero
        ->falseIcon('heroicon-o-x-circle') // Ícono para falso
        ->trueColor('success') // Color para verdadero
        ->falseColor('danger')// Color para falso
    ->searchable(),
    Tables\Columns\IconColumn::make('estado')
        ->label('Activo')
        ->boolean()
        ->trueIcon('heroicon-o-check-circle') // Ícono para verdadero
        ->falseIcon('heroicon-o-x-circle') // Ícono para falso
        ->trueColor('success') // Color para verdadero
        ->falseColor('danger'), // Color para falso
        ])->defaultSort('created_at', 'desc')
        ->searchable()

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
            'index' => Pages\ListCatalogoInventarios::route('/'),
            'create' => Pages\CreateCatalogoInventario::route('/create'),
            'edit' => Pages\EditCatalogoInventario::route('/{record}/edit'),
        ];
    }
}
