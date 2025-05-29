<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntervencionesEventoDraftResource\Pages;
use App\Filament\Resources\IntervencionesEventoDraftResource\RelationManagers;
use App\Models\IntervencionesEventoDraft;
use App\Models\User;
use App\Models\Especie;
use App\Models\Aerodromo;
use App\Models\Grupo;
use App\Models\CatalogoInventario;
use App\Models\Acciones;
use App\Models\Atractivo;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IntervencionesEventoDraftResource extends Resource
{
    protected static ?string $model = IntervencionesEventoDraft::class;

    protected static ?string $navigationIcon = 'lucide-tower-control';
    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?string $navigationLabel = "Eventos - Intervenciones";
    protected static ?string $modelLabel = 'Eventos - Intervenciones 🚨';


    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                 //Usuario para guardarlo en la tabla draft y luego asociarlo cuando se busque que usuario tiene drafts
            Forms\Components\Select::make('user_id')->label('Usuario')
                ->options(User::pluck('name', 'id'))
                ->required()
                ->default(Filament::auth()->id())
                ->disabled()
                ->dehydrated(true),
            Forms\Components\TextInput::make('tipo_evento')
                ->label('Tipo de Evento')
                ->default('Intervencion')
                ->disabled()
                ->dehydrated(true),
            Forms\Components\Select::make('origen')
                ->label('Origen del Reporte')
                ->options([
                    'TWR' => 'TWR',
                    'SSEI'=>'SSEI',
                    'AVSEC'=>'AVSEC',
                ])
                ->required(),
            //Coordenada x con la Api
            Forms\Components\TextInput::make('coordenada_x')
                ->label('Coordenada X')
                ->numeric()
                ->step(0.000001)
                ->disabled()
                ->dehydrated(true)
                ->default(fn() => data_get(static::getWeatherData(), 'coord.lat')
                    ? number_format(data_get(static::getWeatherData(), 'coord.lat'), 8, '.', '')
                    : null),
            //Coordenada Y
            Forms\Components\TextInput::make('coordenada_y')
                ->label('Coordenada Y')
                ->numeric()
                ->disabled()
                ->step(0.000001)
                ->dehydrated(true)
                ->default(fn() => data_get(static::getWeatherData(), 'coord.lon')
                    ? number_format(data_get(static::getWeatherData(), 'coord.lon'), 8, '.', '')
                    : null),
            //Temperatura con la Api
            Forms\Components\TextInput::make('temperatura')
                ->label('Temperatura')
                ->suffix('°C')
                ->disabled()
                ->dehydrated(true)
                ->default(fn() => data_get(static::getWeatherData(),'main.temp')),
            //Viento con la Api
            Forms\Components\TextInput::make('viento')
                ->label('Viento')
                ->numeric()
                ->disabled()
                ->dehydrated(true)
                ->suffix('m/s')
                ->default(fn() => data_get(static::getWeatherData(),'wind.speed')),
            //Humedad con la Api
            Forms\Components\TextInput::make('humedad')
                ->label('Humedad')
                ->suffix('%')
                ->disabled()
                ->dehydrated(true)
                ->default(fn() => data_get(static::getWeatherData(),'main.humidity')),
            //Grupo de especies para obtener el grupo especifico.
            Forms\Components\Select::make('grupos_id')
                ->label('Grupo')
                ->options(Grupo::orderBy('nombre')->pluck('nombre', 'id'))
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('especies_id', null)),
            //Especies, que dependiendo del grupo se desplieguen las especies del grupo escogido.
            Forms\Components\Select::make('especies_id')
                ->label('Especie')
                ->options(function (callable $get) {
                    $grupoId = $get('grupos_id');
                    if (!$grupoId) {
                        return [];
                    }
                    return Especie::where('grupos_id', $grupoId)->orderBy('nombre_cientifico')->pluck('nombre_cientifico', 'id');
                })
                ->searchable()
                ->required()
                ->disabled(fn (callable $get) => !$get('grupos_id')),
            //Atractivo para la fauna
            Forms\Components\Select::make('atractivos_id')
                ->label('Atractivo')
                ->options(Atractivo::pluck('nombre', 'id'))
                ->searchable()
                ->required(),
            //Select para escoger la cantidad de fauna vista.
            Forms\Components\Select::make('vistos')
            ->options(['0' => '0 (0)',
                        '1(1)' => '1 (1)',
                        '2(2)' => '2 (2)',
                        '3(3)' => '3 (3)',
                        '4(4)' => '4 (4)',
                        '5(5)' => '5 (5)',
                        '6(6)' => '6 (6)',
                        '7(7)' => '7 (7)',
                        '8(8)' => '8 (8)',
                        '9(9)' => '9 (9)',
                        '10(10)' => '10 (10)',
                        '15(11-20)' => '15 (11–20)',
                        '25(21-30)' => '25 (21–30)',
                        '35(31-40)' => '35 (31–40)',
                        '45(41-50)' => '45 (41–50)',
                        '63(51-75)' => '63 (51–75)',])
            ->label('Vistos')
            ->placeholder('Seleccione una cantidad'),
            //Select para escoger la cantidad de fauna sacrificada , si es el caso
            Forms\Components\Select::make('sacrificados')
            ->label('Sacrificados')
            ->options(['0' => '0 (0)',
                        '1(1)' => '1 (1)',
                        '2(2)' => '2 (2)',
                        '3(3)' => '3 (3)',
                        '4(4)' => '4 (4)',
                        '5(5)' => '5 (5)',
                        '6(6)' => '6 (6)',
                        '7(7)' => '7 (7)',
                        '8(8)' => '8 (8)',
                        '9(9)' => '9 (9)',
                        '10(10)' => '10 (10)',
                        '15(11-20)' => '15 (11–20)',
                        '25(21-30)' => '25 (21–30)',
                        '35(31-40)' => '35 (31–40)',
                        '45(41-50)' => '45 (41–50)',
                        '63(51-75)' => '63 (51–75)',])
            ->placeholder('Seleccione una cantidad'),
            //Select para escoger cantidad de fauna dispersada
            Forms\Components\Select::make('dispersados')
            ->label('Dispersados')
            ->options(['0' => '0 (0)',
                        '1(1)' => '1 (1)',
                        '2(2)' => '2 (2)',
                        '3(3)' => '3 (3)',
                        '4(4)' => '4 (4)',
                        '5(5)' => '5 (5)',
                        '6(6)' => '6 (6)',
                        '7(7)' => '7 (7)',
                        '8(8)' => '8 (8)',
                        '9(9)' => '9 (9)',
                        '10(10)' => '10 (10)',
                        '15(11-20)' => '15 (11–20)',
                        '25(21-30)' => '25 (21–30)',
                        '35(31-40)' => '35 (31–40)',
                        '45(41-50)' => '45 (41–50)',
                        '63(51-75)' => '63 (51–75)',])
            ->placeholder('Seleccione una cantidad'),
            //Insertar imagen
            Forms\Components\FileUpload::make('fotos')
                    ->label('Fotos')
                    ->multiple()
                    ->maxFiles(5)
                    ->image()
                    ->disk('public')
                    ->directory('intervenciones')
                    ->preserveFilenames()
                    ->reorderable()
                    ->nullable(),
            //Comentarios Opcionales
            Forms\Components\Textarea::make('comentarios')->label('Comentarios')->nullable(),
/*----------------------------------------------------SECCIÓN PARA ESCOGER LA CANTIDAD DE MUNICIONES USADAS-------------------------------------------------- */
            Forms\Components\Repeater::make('municion_utilizada')
                ->label('')
                ->schema([
                Forms\Components\Select::make('aerodromo_id')
                ->label('Aeropuerto')
                ->options(Aerodromo::pluck('nombre', 'id'))
                ->required()
                ->default(Filament::auth()->user()->aerodromo_id)
                ->disabled()
                ->dehydrated(true),
                //Catalogo de Inventario
                Forms\Components\Select::make('catinventario_id')
                ->label('Herramienta Utilizada:')
                ->options(CatalogoInventario::pluck('nombre', 'id'))
                ->searchable()
                ->reactive()
                ->required()
                ->dehydrated()
                ->afterStateUpdated(function (callable $set, $state) {
                    //Cuando se seleccione una herramienta se busca en el inventario
                    $accionId = CatalogoInventario::where('id', $state)->value('acciones_id');
                    $set('acciones_id', $accionId);
                }),
                 //Acciones que dependiendo de la herramienta se elija de una vez la acción asociada a la herramienta
                Forms\Components\Select::make('acciones_id')
                ->label('Tipo de Acción Realizada:')
                ->options(Acciones::pluck('nombre', 'id'))
                ->searchable()
                ->required()
                ->disabled()
                ->dehydrated(),
                Forms\Components\TextInput::make('cantidad_utilizada')
                ->label('Cantidad a utilizar')
                ->numeric()
                ->required()
            ])
            ->minItems(1)
            ->defaultItems(1)
            ->reorderable()
            ->collapsible(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('id')->label('Código'),
            Tables\Columns\TextColumn::make('user.name')->label('Nombre'),
            Tables\Columns\TextColumn::make('origen')->label('Origen'),
            Tables\Columns\TextColumn::make('tipo_evento')->label('Tipo de Evento'),
            Tables\Columns\TextColumn::make('created_at')->label('Fecha')->dateTime('d/m/Y'),
            ])
            ->filters([
                //FILTROS PARA BUSQUEDA
                Tables\Filters\SelectFilter::make('origen')->label('Origen')
                ->options([
                    'TWR' => 'TWR',
                    'SSEI'=>'SSEI',
                    'AVSEC'=>'AVSEC',
                ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                //Ventanita para las actualizaciones.
            Tables\Actions\Action::make('actualizaciones')
            ->label('Actualizaciones')
            ->icon('heroicon-o-eye')
            ->modalHeading('Actualizaciones del Reporte')
            ->form([
                Forms\Components\Textarea::make('actualizacion')
                    ->label('Añadir Nueva Actualización')
                    ->rows(4)
                    ->required(),
            ])
            ->modalContent(function ($record) {
            return view('components.actualizaciones-list', [ //Vista blade en la carpeta resources.
            // Relación polimórfica en el modelo ReporteImpactoAviar con el modelo ActualizacionesReporte
            'actualizaciones' => $record->actualizacionesEvento()->latest()->get(),
            ]);
            })
            ->action(function ($record, array $data): void {
                $record->actualizacionesEvento()->create([
                    'actualizacion' => $data['actualizacion'],
                    'autor' => Filament::auth()->id()
                ]);
            }),
            /*---------------------------Reporte en pdf-------------------------------------------------*/
            Tables\Actions\Action::make('downloadPDF')
                ->label('PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('danger')
                ->url(fn($record) => route('eventoIntervenciones.pdf', $record->id))
                // ->openUrlInNewTab(), // Esto hace que el PDF se abra en una nueva pestaña
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
            //
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIntervencionesEventoDrafts::route('/'),
            'create' => Pages\CreateIntervencionesEventoDraft::route('/create'),
            'edit' => Pages\EditIntervencionesEventoDraft::route('/{record}/edit'),
        ];
    }
protected static function getWeatherData(string $city = 'Panama,PA')
{
    return \Illuminate\Support\Facades\Cache::remember("weather_{$city}", now()->addMinutes(15), function () use ($city) {
        $response = \Illuminate\Support\Facades\Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => env('OPENWEATHERMAP_KEY'),
            'units' => 'metric',
            'lang' => 'es',
        ]);
        return $response->successful() ? $response->json() : null;
    });
}
}
