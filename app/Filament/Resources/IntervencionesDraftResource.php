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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IntervencionesDraftResource extends Resource
{
    protected static ?string $model = IntervencionesDraft::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label('Usuario')
                ->options(User::pluck('name', 'id'))
                ->required()
                ->default(Filament::auth()->id())
                ->disabled()
                ->dehydrated(true),

            TextInput::make('coordenada_x')
                ->label('Coordenada X')
                ->numeric()
                ->step(0.000001)
                ->disabled()
                ->dehydrated()
                ->default(fn () => number_format(data_get(static::getWeatherData(), 'coord.lat', 0), 8, '.', '')),

            TextInput::make('coordenada_y')
                ->label('Coordenada Y')
                ->numeric()
                ->step(0.000001)
                ->disabled()
                ->dehydrated()
                ->default(fn () => number_format(data_get(static::getWeatherData(), 'coord.lon', 0), 8, '.', '')),

            TextInput::make('temperatura')
                ->label('Temperatura')
                ->suffix('°C')
                ->disabled()
                ->dehydrated()
                ->default(fn () => data_get(static::getWeatherData(), 'main.temp')),

            TextInput::make('viento')
                ->label('Viento')
                ->suffix('m/s')
                ->numeric()
                ->disabled()
                ->dehydrated()
                ->default(fn () => data_get(static::getWeatherData(), 'wind.speed')),

            TextInput::make('humedad')
                ->label('Humedad')
                ->suffix('%')
                ->disabled()
                ->dehydrated()
                ->default(fn () => data_get(static::getWeatherData(), 'main.humidity')),

            Select::make('grupos_id')
                ->label('Grupo')
                ->options(Grupo::orderBy('nombre')->pluck('nombre', 'id'))
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('especies_id', null)),

            Select::make('especies_id')
                ->label('Especie')
                ->options(function (callable $get) {
                    $grupoId = $get('grupos_id');
                    return $grupoId
                        ? Especie::where('grupos_id', $grupoId)->orderBy('nombre_cientifico')->pluck('nombre_cientifico', 'id')
                        : [];
                })
                ->searchable()
                ->required()
                ->disabled(fn (callable $get) => !$get('grupos_id')),

            Select::make('atractivos_id')
                ->label('Atractivo')
                ->options(Atractivo::pluck('nombre', 'id'))
                ->searchable()
                ->required(),

            Select::make('vistos')
                ->label('Vistos')
                ->options(self::getCantidadOptions())
                ->placeholder('Seleccione una cantidad'),

            Select::make('sacrificados')
                ->label('Sacrificados')
                ->options(self::getCantidadOptions())
                ->placeholder('Seleccione una cantidad'),

            Select::make('dispersados')
                ->label('Dispersados')
                ->options(self::getCantidadOptions())
                ->placeholder('Seleccione una cantidad'),

            FileUpload::make('fotos')
                ->label('Fotos')
                ->multiple()
                ->disk('public')
                ->directory('intervenciones')
                ->preserveFilenames()
                ->reorderable()
                ->nullable(),

            Textarea::make('comentarios')
                ->label('Comentarios')
                ->nullable(),

            Forms\Components\Repeater::make('municion_utilizada')
                ->label('Municiones Utilizadas')
                ->schema([
                Forms\Components\Select::make('aerodromo_id')
                ->label('Aeropuerto')
                ->options(Aerodromo::pluck('nombre', 'id'))
                ->required()
                ->default(Filament::auth()->user()->aerodromo_id)
                ->disabled()
                ->dehydrated(true),
                    Select::make('catinventario_id')
                        ->label('Herramienta Utilizada')
                        ->options(CatalogoInventario::pluck('nombre', 'id'))
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            $accionId = CatalogoInventario::where('id', $state)->value('acciones_id');
                            $set('acciones_id', $accionId);
                        }),

                    Select::make('acciones_id')
                        ->label('Tipo de Acción')
                        ->options(Acciones::pluck('nombre', 'id'))
                        ->required()
                        ->disabled()
                        ->dehydrated(true),

                    TextInput::make('cantidad_utilizada')
                        ->label('Cantidad utilizada')
                        ->numeric()
                        ->required(),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // columnas si deseas agregar
            ])
            ->filters([])
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
            '15' => '15 (11–20)',
            '25' => '25 (21–30)',
            '35' => '35 (31–40)',
            '45' => '45 (41–50)',
            '63' => '63 (51–75)',
        ];
    }
}
