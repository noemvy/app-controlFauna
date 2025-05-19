<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarioMunicionesResource\Pages;
use App\Filament\Resources\InventarioMunicionesResource\RelationManagers\MovimientoInventarioRelationManager;
use App\Models\CatalogoInventario;
use App\Models\InventarioMuniciones;
use App\Models\Aerodromo;
use App\Models\MovimientoInventario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use app\Filament\Resources\MovimientoInventarioRelationManagerResource;
use Filament\Tables\Filters\SelectFilter;



class InventarioMunicionesResource extends Resource
{
    protected static ?string $model = InventarioMuniciones::class;


    protected static ?string $navigationIcon = 'lucide-package';
    protected static ?string $navigationLabel = "Inventario de Equipos";
    protected static ?string $navigationGroup = 'Inventario';
    protected static ?int $navigationSort = 9;
    protected static ?string $modelLabel = 'Inventario de Equipos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('catinventario_id')
                    ->label('Equipo')
                    ->placeholder('Eliga el equipo')
                    ->options(CatalogoInventario::all()->pluck('nombre','id'))
                        ->required()
                        ->searchable()
                        ->preload(),
                Forms\Components\Select::make('aerodromo_id')
                    ->label('Aeropuerto')
                    ->placeholder('Eliga el Aeropuerto al que pertenece')
                    ->options(Aerodromo::all()->pluck('nombre','id'))
                        ->required()
                        ->searchable()
                        ->preload(),
                // Forms\Components\TextInput::make('cantidad_actual')
                //     ->label('Cantidad Actual')
                //     ->required()
                //     ->maxLength(20),
                Forms\Components\TextInput::make('cantidad_minima')
                    ->label('Cantidad Minima')
                    ->required()
                    ->maxLength(20),
                            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('catalogoInventario.nombre')->label('Equipo'),
            Tables\Columns\TextColumn::make('aerodromo.nombre')->label('Aeródromo'),
            Tables\Columns\TextColumn::make('cantidad_actual')
    ->label('Cantidad Disponible')
    ->formatStateUsing(function ($state, $record) {
        return $state . ' unidades';
    })
    ->color(function ($state, $record) {
        if ($state <= $record->cantidad_minima) {
            return 'danger'; // rojo
        } elseif ($state <= $record->cantidad_minima + 5) {
            return 'warning'; // amarillo
        }
        return 'success'; // verde
    }),

            Tables\Columns\TextColumn::make('cantidad_minima')->label('Cantidad Minima'),

            Tables\Columns\TextColumn::make('movimientos_count')->label('Número de Movimientos')
                ->getStateUsing(function ($record) {
                    return $record->movimientos->count();
                }),
                ])


            ->filters([
                SelectFilter::make('aerodromo.id')
                ->label('Filtrar por Aeropuerto')
                ->relationship('aerodromo', 'nombre')
                ->placeholder('Selecciona un Aeropuerto'),

            ])
            ->actions([

                Tables\Actions\EditAction::make()->label('Crear Movimientos'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

public static function getRelations(): array
{
    return [
        MovimientoInventarioRelationManager::class,
    ];
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventarioMuniciones::route('/'),
            'create' => Pages\CreateInventarioMuniciones::route('/create'),
            'edit' => Pages\EditInventarioMuniciones::route('/{record}/edit'),
        ];
    }
}
