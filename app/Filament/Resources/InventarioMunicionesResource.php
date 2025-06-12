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
use Carbon\Carbon;


class InventarioMunicionesResource extends Resource
{
    protected static ?string $model = InventarioMuniciones::class;


    protected static ?string $navigationIcon = 'lucide-package';
    protected static ?string $navigationLabel = "Inventario de Equipos";
    protected static ?string $navigationGroup = 'Inventario';
    protected static ?int $navigationSort = 999;
    protected static ?string $modelLabel = 'Inventario de Equipos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Select::make('aerodromo_id')
                ->label('Aeropuerto')
                ->placeholder('Eliga el Aeropuerto al que pertenece')
                ->options(Aerodromo::all()->pluck('nombre','id'))
                ->required()->searchable()->preload()
                ->reactive(),
                Forms\Components\Select::make('catinventario_id')
                ->label('Equipo')
                ->placeholder('Elija el equipo')->required()
                ->searchable()->preload()->reactive()
                ->options(function (callable $get, $record) {
                $aerodromoId = $get('aerodromo_id');
                $query = CatalogoInventario::query();
                if ($aerodromoId) {
                    $yaRegistrados = InventarioMuniciones::where('aerodromo_id', $aerodromoId)
                        ->pluck('catinventario_id');
                    $query->whereNotIn('id', $yaRegistrados);
                    // Asegura que el equipo actual (en edición) sí se incluya
                    if ($record && $record->catinventario_id) {
                        $query->orWhere('id', $record->catinventario_id);
                    }
                }
                return $query->orderBy('nombre')->pluck('nombre', 'id');
            }),
            Forms\Components\TextInput::make('cantidad_minima')
                ->label('Cantidad Mínima')
                ->required()
                ->numeric()
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
                $minima = $record->cantidad_minima;
                if ($state >= $minima) {
                    return 'success';
                }
                return 'warning';
            }),
            Tables\Columns\TextColumn::make('cantidad_minima')->label('Cantidad Minima'),
            Tables\Columns\TextColumn::make('movimientos_count')->label('Movimientos')
                ->getStateUsing(function ($record) {
                    return $record->movimientos->count();
                }),
            Tables\Columns\TextColumn::make('created_at')->label('Creado')
            ->formatStateUsing(fn ($state) => Carbon::parse($state)->timezone('America/Panama'))
            ->dateTime('d/m/Y')
            ->sortable(),
            ])->defaultSort('created_at', 'desc')
            ->searchable()
            /*-------------------------------------FILTROS-------------------------------------------------------------*/
            ->filters([
                SelectFilter::make('aerodromo.id')
                ->label('Filtrar por Aeropuerto')
                ->relationship('aerodromo', 'nombre')
                ->placeholder('Selecciona un Aeropuerto'),
                SelectFilter::make('catalogoInventario.nombre')
                ->label('Filtrar por Equipo')
                ->relationship('catalogoInventario','nombre')
                ->placeholder('Seleccione un Equipo')

            ])
            ->actions([

                Tables\Actions\EditAction::make()->label('Crear Movimientos'),

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
