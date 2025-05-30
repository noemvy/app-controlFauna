<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntervencionesDraftResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Models\User;
use App\Models\Especie;
use App\Models\Aerodromo;
use App\Models\Grupo;
use App\Models\CatalogoInventario;
use App\Models\Acciones;
use App\Models\Atractivo;
use App\Models\IntervencionesDraft;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class IntervencionesDraftResource extends Resource
{
    protected static ?string $model = IntervencionesDraft::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                 //Usuario para guardarlo en la tabla draft y luego asociarlo cuando se busque que usuario tiene drafts
            Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->options(User::pluck('name', 'id'))
                ->required()
                ->default(Filament::auth()->id())
                ->disabled()
                ->dehydrated(true),
            //Coordenada x con la Api
            TextInput::make('coordenada_x')
                ->label('Coordenada X')
                ->numeric()
                ->step(0.000001)
                ->disabled()
                ->dehydrated()
                ->default(fn() => data_get(static::getWeatherData(), 'coord.lat')
                    ? number_format(data_get(static::getWeatherData(), 'coord.lat'), 8, '.', '')
                    : null),
            //Coordenada Y
            TextInput::make('coordenada_y')
                ->label('Coordenada Y')
                ->numeric()
                ->disabled()
                ->step(0.000001)
                ->dehydrated()
                ->default(fn() => data_get(static::getWeatherData(), 'coord.lon')
                    ? number_format(data_get(static::getWeatherData(), 'coord.lon'), 8, '.', '')
                    : null),

            //Temperatura con la Api
            TextInput::make('temperatura')
                ->label('Temperatura')
                ->suffix('°C')
                ->disabled()
                ->dehydrated()
                ->default(fn() => data_get(static::getWeatherData(),'main.temp')),
            //Viento con la Api
            TextInput::make('viento')
                ->label('Viento')
                ->numeric()
                ->disabled()
                ->dehydrated()
                ->suffix('m/s')
                ->default(fn() => data_get(static::getWeatherData(),'wind.speed')),
            //Humedad con la Api
            TextInput::make('humedad')
                ->label('Humedad')
                ->suffix('%')
                ->disabled()
                ->dehydrated()
                ->default(fn() => data_get(static::getWeatherData(),'main.humidity')),
            //Grupo de especies para obtener el grupo especifico.
            Select::make('grupos_id')
                ->label('Grupo')
                ->options(Grupo::orderBy('nombre')->pluck('nombre', 'id'))
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('especies_id', null)),
            //Especies, que dependiendo del grupo se desplieguen las especies del grupo escogido.
            Select::make('especies_id')
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
            Select::make('atractivos_id')
                ->label('Atractivo')
                ->options(Atractivo::pluck('nombre', 'id'))
                ->searchable()
                ->required(),
            //Select para escoger la cantidad de fauna vista.
            Select::make('vistos')
            ->options(['0' => '0 (0)',
                        '1' => '1 (1)',
                        '2' => '2 (2)',
                        '3' => '3 (3)',
                        '4' => '4 (4)',
                        '5' => '5 (5)',
                        '6' => '6 (6)',
                        '7' => '7 (7)',
                        '8' => '8 (8)',
                        '9' => '9 (9)',
                        '10' => '10 (10)',
                        '15' => '15 (11–20)',
                        '25' => '25 (21–30)',
                        '35' => '35 (31–40)',
                        '45' => '45 (41–50)',
                        '63' => '63 (51–75)',])
            ->label('Vistos')
            ->placeholder('Seleccione una cantidad'),
            //Select para escoger la cantidad de fauna sacrificada , si es el caso
            Select::make('sacrificados')
            ->label('Sacrificados')
            ->options(['0' => '0 (0)',
                        '1' => '1 (1)',
                        '2' => '2 (2)',
                        '3' => '3 (3)',
                        '4' => '4 (4)',
                        '5' => '5 (5)',
                        '6' => '6 (6)',
                        '7' => '7 (7)',
                        '8' => '8 (8)',
                        '9' => '9 (9)',
                        '10' => '10 (10)',
                        '15' => '15 (11–20)',
                        '25' => '25 (21–30)',
                        '35' => '35 (31–40)',
                        '45' => '45 (41–50)',
                        '63' => '63 (51–75)',])
            ->placeholder('Seleccione una cantidad'),

            //Select para escoger cantidad de fauna dispersada
            Select::make('dispersados')
            ->label('Dispersados')
            ->options(['0' => '0 (0)',
                        '1' => '1 (1)',
                        '2' => '2 (2)',
                        '3' => '3 (3)',
                        '4' => '4 (4)',
                        '5' => '5 (5)',
                        '6' => '6 (6)',
                        '7' => '7 (7)',
                        '8' => '8 (8)',
                        '9' => '9 (9)',
                        '10' => '10 (10)',
                        '15' => '15 (11–20)',
                        '25' => '25 (21–30)',
                        '35' => '35 (31–40)',
                        '45' => '45 (41–50)',
                        '63' => '63 (51–75)',])
            ->placeholder('Seleccione una cantidad'),
            //Insertar imagen
            FileUpload::make('fotos')
                    ->label('Fotos')
                    ->multiple()
                    ->disk('public')
                    ->directory('intervenciones')
                    ->preserveFilenames()
                    ->reorderable()
                    ->nullable(),
            //Comentarios Opcionales
            Textarea::make('comentarios')->label('Comentarios')->nullable(),

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
                Select::make('catinventario_id')
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
                Select::make('acciones_id')
                ->label('Tipo de Acción Realizada:')
                ->options(Acciones::pluck('nombre', 'id'))
                ->searchable()
                ->required()
                ->disabled()
                ->dehydrated(),
                TextInput::make('cantidad_utilizada')
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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function shouldRegisterNavigation(): bool
    {
        return false; // No se muestra en el menú lateral
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIntervencionesDrafts::route('/'),
            'create' => Pages\CreateIntervencionesDraft::route('/create'),
            'edit' => Pages\EditIntervencionesDraft::route('/{record}/edit'),
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
