<?php

namespace App\Filament\Resources\InventarioMunicionesResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CatalogoInventario;
use App\Models\InventarioMuniciones;
use App\Models\MovimientoInventario;
use App\Models\TransferenciaMuniciones;
use App\Models\Aerodromo;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Facades\Filament;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Grid;
use Carbon\Carbon;

class MovimientoInventarioRelationManager extends RelationManager
{
    protected static string $relationship = 'movimientos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }
    public function table(Table $table): Table
    {
        return $table
        /*----------------------------------------Vista Final de los Movimientos-----------------------------------*/
            ->columns([
            Tables\Columns\TextColumn::make('tipo_movimiento')->label('Tipo de Movimiento'),
            Tables\Columns\TextColumn::make('cantidad_usar')
            ->label('Cantidad')
            ->getStateUsing(function ($record) {
                $inventario = InventarioMuniciones::where('aerodromo_id', $record->aerodromo_id)
                    ->where('catinventario_id', $record->catinventario_id)
                    ->first();
                return $inventario ? $inventario->cantidad_actual : 0;
            }),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Fecha y Hora')
            ->formatStateUsing(fn ($state) => Carbon::parse($state)->timezone('America/Panama'))
            ->dateTime('d/m/Y')
            ->sortable(),
            Tables\Columns\TextColumn::make('user.name')->label('Responsable')->searchable(),

        ])->defaultSort('created_at', 'desc')
        ->actions([
            Tables\Actions\Action::make('ver_detalles')
            ->label('Ver Detalles')
            ->icon('heroicon-o-eye')
            ->modalHeading('Detalles')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Cerrar')
            ->modalContent(function ($record) {
                return view('components.transferencia-detalles', compact('record'));
            })
            ->visible(fn ($record) => $record->tipo_movimiento === 'Transferencia'),
        ])
        /*--------------------------------------FILTROS----------------------------------------------------------*/
        ->filters([
            SelectFilter::make('tipo_movimiento')
            ->label('Filtrar por Tipo de Movimiento')
            ->options([
                'Compra' => '🟢Entrada-Compra',
                'Donacion' => '🟢Entrada-Donación',
                'Consumo' => '🔴 Salida-Consumo',
                'Baja' => '🔴Salida-Baja',
                'Ajuste' => '⚙️Ajuste',
                'Transferencia' => 'Transferencia',
            ])
        ])


        /*-------------------------------------BOTÓN DE 🟢ENTRADA------------------------------------------------- */
        ->headerActions([
        Tables\Actions\Action::make('entrada')
            ->label('🟢 Entrada')
            ->form([
            Grid::make(2)->schema([
            Forms\Components\Select::make('aerodromo_id')
                ->label('Aeródromo')->options(Aerodromo::pluck('nombre', 'id'))->required()
                ->reactive()
                ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->aerodromo_id)
                ->afterStateUpdated(fn (callable $set) => $set('catinventario_id', null))
                ->disabled()->dehydrated(true),
            Forms\Components\Select::make('catinventario_id')
                ->label('Equipo')
                ->options(CatalogoInventario::pluck('nombre', 'id'))->required()->reactive()
                ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->catinventario_id)
                ->disabled()->dehydrated(true),
            Forms\Components\Select::make('tipo_movimiento')
                ->label('Tipo de Movimiento')
                ->options([
                'Compra' => '🟢 Entrada - Compra'
                ])->default("Compra")
                ->disabled()->dehydrated(true)
                ->required(),
            Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->options(User::pluck('name', 'id'))
                ->default(Filament::auth()->id())
                ->required()
                ->disabled()->dehydrated(true),
            Forms\Components\Placeholder::make('stock_actual')
                ->label('Stock disponible')
                ->content(function ($get) {
                    return InventarioMuniciones::where('aerodromo_id', $get('aerodromo_id'))
                        ->where('catinventario_id', $get('catinventario_id'))
                        ->first()?->cantidad_actual ?? 'No disponible';
                }),
            Forms\Components\TextInput::make('cantidad_usar')
                ->label('Cantidad del movimiento')->numeric()->required(),
            Forms\Components\Textarea::make('comentario')
                ->label('Comentario')->maxLength(255)->columnSpanFull(),

        ])
        ])
        /*-----------------------------LOGICA PARA CREAR MOVIMIENTOS - La logica se encuentra en el modelo MovimientoInventario---------------------------------------------------*/
        ->action(function (array $data) {
            try {
            $movimiento = MovimientoInventario::create($data);
            //Alertas para verificar si fue exitoso o no los movimientos
            if ($movimiento) {
                Notification::make()
                    ->title('Entrada registrada correctamente')->success()->send();
            } else {
                throw new \Exception('Error al registrar la entrada');
            }
        } catch (\Exception $e) {
            Notification::make()->title('Error al registrar la entrada')->body($e->getMessage())->danger()->send();
            }
        }),
        /*-----------------------------------BOTÓN DE 🔴SALIDA---------------------------------------------------- */
        Tables\Actions\Action::make('salida')
            ->label('🔴 Salida')
            ->form([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Select::make('aerodromo_id')
                    ->label('Aeródromo')
                    ->options(Aerodromo::pluck('nombre', 'id'))->required()->reactive()
                    ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->aerodromo_id)
                    ->afterStateUpdated(fn (callable $set) => $set('catinventario_id', null))
                    ->disabled()->dehydrated(true),
                Forms\Components\Select::make('catinventario_id')
                    ->label('Equipo')
                    ->options(CatalogoInventario::pluck('nombre', 'id'))->required()->reactive()
                    ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->catinventario_id)
                    ->disabled()->dehydrated(true),
                Forms\Components\Select::make('user_id')
                    ->label('Usuario')
                    ->options(User::pluck('name', 'id'))->required()
                    ->default(Filament::auth()->id())
                    ->disabled()->dehydrated(true),
                Forms\Components\Select::make('tipo_movimiento')
                    ->label('Tipo de Movimiento')
                    ->options([
                        'Consumo' => '🔴 Salida - Consumo',
                        'Baja' => '🔴 Salida - Baja',
                    ])->required(),
                Forms\Components\Placeholder::make('stock_actual')
                    ->label('Stock disponible')
                    ->content(function ($get) {
                        return InventarioMuniciones::where('aerodromo_id', $get('aerodromo_id'))
                            ->where('catinventario_id', $get('catinventario_id'))
                            ->first()?->cantidad_actual ?? 'No disponible';
                    }),
                Forms\Components\TextInput::make('cantidad_usar')
                    ->label('Cantidad del movimiento')->numeric()->required(),
                Forms\Components\Textarea::make('comentario')
                    ->label('Comentario')->maxLength(255)->columnSpanFull(),
            ])
        ])
        /*-----------------------------LOGICA PARA CREAR MOVIMIENTOS - La logica se encuentra en el modelo MovimientoInventario---------------------------------------------------*/
        ->action(function (array $data) {
            try {
        $movimiento = MovimientoInventario::create($data);
        // Alertas para procesar si fue exitoso o no el movimiento.
        if ($movimiento) {
            Notification::make()
                ->title('Salida registrada correctamente')
                ->success()
                ->send();
        } else {
            throw new \Exception('Error al registrar la Salida');
        }
            } catch (\Exception $e) {
            Notification::make()
                ->title('Error al registrar la salida')
                ->body($e->getMessage())
                ->danger()
                ->send();
            }
        }),
    /*-------------------------------------BOTON DE ⚙️AJUSTE------------------------------------------------*/
    Tables\Actions\Action::make('ajuste')
            ->label('⚙ Ajuste')
            ->form([
        Forms\Components\Grid::make(2)->schema([
            Forms\Components\Select::make('aerodromo_id')
            ->label('Aeródromo')
            ->options(Aerodromo::pluck('nombre', 'id'))->required()
            ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->aerodromo_id)
            ->disabled()->dehydrated(true),
            Forms\Components\Select::make('catinventario_id')
                ->label('Equipo')
                ->options(CatalogoInventario::pluck('nombre', 'id'))->required()
                ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->catinventario_id)
                ->disabled()->dehydrated(true),
            Forms\Components\Select::make('tipo_movimiento')
                ->label('Tipo de Movimiento')
                ->options([
                    'Ajuste' => 'Ajuste',
                ])->default('Ajuste')
                ->required()->disabled()->dehydrated(true),
            Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->options(User::pluck('name', 'id'))->required()
                ->default(Filament::auth()->id())
                ->disabled()->dehydrated(true),
            Forms\Components\Placeholder::make('stock_actual')
                ->label('Stock Actual')
                ->content(function ($get) {
                    return InventarioMuniciones::where('aerodromo_id', $get('aerodromo_id'))
                        ->where('catinventario_id', $get('catinventario_id'))
                        ->first()?->cantidad_actual ?? 'No disponible';
                }),
            Forms\Components\TextInput::make('cantidad_ajustada')
                ->label('Nuevo stock ajustado')->numeric()->required(),
            Forms\Components\Textarea::make('comentario')
                ->label('Comentario')->maxLength(255)->columnSpanFull(),
        ])
            ])
        /*---------------------------------MANEJO DE ERRORES PARA EL TIPO DE MOVIMIENTO DE AJUSTE----------------------------------------*/
            ->action(function (array $data) {
            try {
            $inventario = InventarioMuniciones::where('aerodromo_id', $data['aerodromo_id'])
                ->where('catinventario_id', $data['catinventario_id'])
                ->first();
            if (!$inventario) {
                throw new \Exception('No se encontró el inventario para ajustar.');
            }
            // Actualiza el stock actual directamente
            $inventario->cantidad_actual = $data['cantidad_ajustada'];
            MovimientoInventario::create([
                'aerodromo_id' => $data['aerodromo_id'],
                'catinventario_id' => $data['catinventario_id'],
                'tipo_movimiento' => $data['tipo_movimiento'],
                'cantidad_usar' => $data['cantidad_ajustada'] ,
                'user_id' => $data['user_id'],
                'comentario' => $data['comentario'],
            ]);
            $inventario->save();
            // Crea un registro en movimiento_inventario como "Ajuste
            Notification::make()
                ->title('Ajuste realizado correctamente')
                ->success()
                ->send();
            } catch (\Exception $e) {
            Notification::make()
                ->title('Error al realizar el ajuste')
                ->body($e->getMessage())
                ->danger()
                ->send();
            }
        }),
/*----------------------------------------✈️TRANSFERENCIA ENTRE AERODROMOS-----------------------------------------------------------------*/
        Tables\Actions\Action::make('transferir')
        ->label('✈️Transferir')
        ->form([
        Forms\Components\Grid::make(2)->schema([
            Forms\Components\Select::make('aerodromo_origen_id')
                ->label('Aeródromo')
                ->options(Aerodromo::pluck('nombre', 'id'))->required()->reactive()
                ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->aerodromo_id)
                ->afterStateUpdated(fn (callable $set) => $set('catinventario_id', null))
                ->disabled()->dehydrated(true),
            Forms\Components\Select::make('aerodromo_destino_id')
                ->label('Aeropuerto Destino')
                ->options(fn (callable $get) =>
                    Aerodromo::where('id', '!=', $get('aerodromo_origen_id'))
                        ->pluck('nombre', 'id')
                )->required(),
            Forms\Components\Select::make('catinventario_id')
                ->label('Equipo')
                ->options(CatalogoInventario::pluck('nombre', 'id'))
                ->required()
                ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->catinventario_id)
                ->disabled()
                ->dehydrated(true),
            Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->options(User::pluck('name', 'id'))->required()
                ->default(Filament::auth()->id())->disabled()->dehydrated(true),
            Forms\Components\Placeholder::make('stock_actual')
                ->label('Stock Actual')
                ->content(function ($get) {
                    return InventarioMuniciones::where('aerodromo_id', $get('aerodromo_origen_id'))
                        ->where('catinventario_id', $get('catinventario_id'))
                        ->first()?->cantidad_actual ?? 'No disponible';
                }),
            Forms\Components\TextInput::make('cantidad')
                ->label('Cantidad a Transferir')->numeric()->required()->minValue(1),
            Forms\Components\Textarea::make('observaciones')
                ->label('Comentarios')->maxLength(255)->columnSpanFull(),
        ]),
    ])
        ->action(function (array $data) {
            try {
            TransferenciaMuniciones::transferir($data);

            Notification::make()
                ->title('Transferencia realizada correctamente.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
        })
    ]);
    }
}
