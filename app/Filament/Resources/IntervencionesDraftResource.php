<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntervencionesDraftResource\Pages;
use App\Models\Acciones;
use App\Models\Aerodromo;
use App\Models\Atractivo;
use App\Models\CatalogoInventario;
use App\Models\Especie;
use App\Models\Grupo;
use App\Models\IntervencionesDraft;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\View;

class IntervencionesDraftResource extends Resource
{
    protected static ?string $model = IntervencionesDraft::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
/*-----------------------------------------Datos de las especies🦜--------------------------------------*/
    Forms\Components\Section::make('Datos de la Fauna')
        ->schema([
    Forms\Components\Select::make('grupos_id')
        ->label('Grupo')
        ->options(Grupo::orderBy('nombre')->pluck('nombre', 'id'))
        ->reactive()->required()
        ->afterStateUpdated(fn (callable $set) => $set('especies_id', null)),
    Forms\Components\Select::make('especies_id')
        ->label('Especie')
        ->options(function (callable $get) {
            $grupoId = $get('grupos_id');
            if (!$grupoId) {
                return [];
            }
            return Especie::where('grupos_id', $grupoId)->orderBy('nombre_cientifico')->pluck('nombre_cientifico', 'id');
        })
        ->searchable()->required()->disabled(fn (callable $get) => !$get('grupos_id')),
    Forms\Components\Select::make('atractivos_id')
        ->label('Atractivo')
        ->options(Atractivo::pluck('nombre', 'id'))
        ->searchable()->required(),
    Forms\Components\Select::make('vistos')
        ->options(self::getCantidadOptions())
        ->label('Vistos')->placeholder('Seleccione una cantidad'),
    Forms\Components\Select::make('sacrificados')
        ->label('Sacrificados')
        ->options(self::getCantidadOptions())
        ->placeholder('Seleccione una cantidad'),
    Forms\Components\Select::make('dispersados')
        ->label('Dispersados')
        ->options(self::getCantidadOptions())
        ->placeholder('Seleccione una cantidad'),
    Forms\Components\FileUpload::make('fotos')
        ->label('Fotos')->multiple()
        ->maxFiles(5)->image()
        ->disk('public')->directory('intervenciones')
        ->preserveFilenames()->reorderable()
        ->nullable()->columnSpanFull(),
        ])->columns(3),
/*-----------------------------------------Datos del clima⛅--------------------------------------------*/
    Forms\Components\Section::make('Datos del Clima y Ubicación')
        ->schema([
    Forms\Components\TextInput::make('coordenada_x')
        ->label('Coordenada X')
        ->id('coordenada_x')
        ->readOnly()->dehydrated(true),
    Forms\Components\TextInput::make('coordenada_y')
        ->label('Coordenada Y')
        ->id('coordenada_y')
        ->readOnly()->dehydrated(true),
    View::make('components.get-coordenadas'),
    Forms\Components\TextInput::make('temperatura')
        ->label('Temperatura')
        ->suffix('°C')
        ->disabled()->dehydrated(true)
        ->default(fn() => data_get(static::getWeatherData(),'main.temp')),
    Forms\Components\TextInput::make('viento')
        ->label('Viento')
        ->numeric()->disabled()->dehydrated(true)->suffix('m/s')
        ->default(fn() => data_get(static::getWeatherData(),'wind.speed')),
    Forms\Components\TextInput::make('humedad')
        ->label('Humedad')
        ->suffix('%')->disabled()->dehydrated(true)
        ->default(fn() => data_get(static::getWeatherData(),'main.humidity')),
        ])->columns(6),
/*----------------------------------------------------SECCIÓN PARA ESCOGER LA CANTIDAD DE MUNICIONES USADAS-------------------------------------------------- */
    Forms\Components\Section::make('Equipo Utilizado')
        ->schema([
    Forms\Components\Repeater::make('municion_utilizada')
        ->label('')
        ->schema([
    Forms\Components\Grid::make(4)
        ->schema([
    Forms\Components\Select::make('aerodromo_id')
        ->label('Aeropuerto')->options(Aerodromo::pluck('nombre', 'id'))
        ->required()->default(Filament::auth()->user()->aerodromo_id)
        ->disabled()->dehydrated(true),
    Forms\Components\Select::make('catinventario_id')
        ->label('Herramienta Utilizada:')
        ->options(CatalogoInventario::where('categoria_equipo', '!=', 'Instrumento')->pluck('nombre', 'id'))
        ->reactive()->required()->dehydrated()
        ->afterStateUpdated(function (callable $set, $state) {
            $inventario = CatalogoInventario::find($state);
            $set('acciones_id', $inventario?->acciones_id);
            $set('es_consumible', $inventario?->es_consumible);
            $set('categoria_equipo', $inventario?->categoria_equipo);
        }),
    Forms\Components\Select::make('acciones_id')
        ->label('Acción Realizada:')
        ->options(Acciones::pluck('nombre', 'id'))
        ->searchable()->required()->disabled()->dehydrated(true),
    Forms\Components\Hidden::make('es_consumible')
        ->dehydrated(false),
    Forms\Components\Hidden::make('categoria_equipo')
        ->dehydrated(false),
    Forms\Components\TextInput::make('cantidad_utilizada')
        ->label('Cantidad Usada')->numeric()
        ->required(fn (callable $get) => $get('es_consumible') === 1)
        ->visible(fn (callable $get) => $get('es_consumible') === 1),
        ]),
        ])->defaultItems(1)->reorderable(false)
        ])->columns(1)->columnSpanFull(),
    /*----------------------------------Datos de comentarios y usuario--------------------------------------*/
    Forms\Components\Section::make('Comentarios y Usuario')
        ->schema([
    Forms\Components\Textarea::make('comentarios')->label('Comentarios')->nullable(),
    Forms\Components\Select::make('user_id')->label('Usuario')
        ->options(User::pluck('name', 'id'))->required()
        ->default(Filament::auth()->id())
        ->disabled()->dehydrated(true),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // columnas si deseas agregar
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
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
        return Cache::remember("weather_{$city}", now()->addMinutes(15), function () use ($city) {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => env('OPENWEATHERMAP_KEY'),
                'units' => 'metric',
                'lang' => 'es',
            ]);

            return $response->successful() ? $response->json() : null;
        });
    }

    protected static function getCantidadOptions(): array
    {
        return [
            '0' => '0 (0)',
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
            '15 (11–20)' => '15 (11–20)',
            '25 (21–30)' => '25 (21–30)',
            '35 (31–40)' => '35 (31–40)',
            '45 (41–50)' => '45 (41–50)',
            '63 (51–75)' => '63 (51–75)',
        ];
    }
}
