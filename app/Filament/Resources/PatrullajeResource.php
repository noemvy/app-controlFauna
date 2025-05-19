<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatrullajeResource\Pages;
use App\Filament\Resources\PatrullajeResource\RelationManagers\IntervencionesRelationManager;
use App\Models\Patrullaje;
use App\Models\User;
use App\Models\Acciones;
use App\Models\Atractivo;
use App\Models\Aerodromo;
use App\Models\Especie;
use App\Models\Grupo;
use App\Models\CatalogoInventario;
use App\Models\IntervencionesDraft;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Select;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Http;

class PatrullajeResource extends Resource
{
    protected static ?string $model = Patrullaje::class;

    protected static ?string $navigationIcon = 'lucide-car-front';
    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('aerodromo_id')
                    ->label('Aeródromo')
                    ->options(Aerodromo::pluck('nombre', 'id'))
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Usuario')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->default(Filament::auth()->id())
                    ->disabled()
                    ->dehydrated(true),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'en_proceso' => '🟢En Proceso',
                        'finalizacion' => '🔴Finalización',
                    ])
                    ->required()
                    ->reactive()
                    ->default('en_proceso'),

            Forms\Components\TextInput::make('inicio')
                    ->label('Inicio')
                    ->default(Carbon::now('America/Panama')->format('Y-m-d H:i:s'))
                    ->required()
                    ->disabled()
                    ->dehydrated(true),
            /*EL CAMPO FIN ESTA EN EL ARCHIVO CreatePatrullaje */

            /*--------------------------------------------------------------------FORMULARIO DE INTERVENCIONES-------------------------------------------------------------------------------------------- */
            Forms\Components\Section::make('Acciones')
                    ->schema([
                    Actions::make([
                    Action::make('agregar_intervencion')
                    ->label('Agregar Intervención')
                    ->icon('heroicon-o-plus')
                    ->color('success')

                    ->modalHeading('Nueva Intervención')
                    ->modalSubmitActionLabel('Guardar')
                    ->modalWidth('4xl')
                    ->form([
                    Grid::make(2)->schema([
                    Forms\Components\Select::make('user_id')
                    ->label('Usuario')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->default(Filament::auth()->id())
                    ->disabled()
                    ->dehydrated(true),
                Select::make('grupos_id')
                    ->label('Grupo')
                    ->options(Grupo::pluck('nombre', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('especies_id', null)),

                Select::make('especies_id')
                    ->label('Especie')
                    ->options(function (callable $get) {
                        $grupoId = $get('grupos_id');

                        if (!$grupoId) {
                            return [];
                        }

                        return Especie::where('grupos_id', $grupoId)->pluck('nombre_cientifico', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->disabled(fn (callable $get) => !$get('grupos_id')),
                    Select::make('catinventario_id')
                    ->label('Herramienta Utilizada:')
                    ->options(CatalogoInventario::pluck('nombre', 'id'))
                    ->searchable()
                    ->reactive()
                    ->required()
                    ->dehydrated()
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Cuando cambia la herramienta, buscamos su acción relacionada y seteamos el campo acciones_id
                        $accionId = CatalogoInventario::where('id', $state)->value('acciones_id');
                        $set('acciones_id', $accionId);
                    }),

                    Select::make('acciones_id')
                        ->label('Tipo de Acción Realizada:')
                        ->options(Acciones::pluck('nombre', 'id'))
                        ->searchable()
                        ->required()
                        ->disabled()
                        ->dehydrated(), // Deshabilitamos para que el usuario no cambie, ya que se determina automáticamente



                    Select::make('atractivos_id')

                            ->label('Atractivo para la Fauna')
                            ->options(Atractivo::pluck('nombre', 'id'))
                            ->searchable()
                            ->required(),

                    TextInput::make('vistos')->numeric()->label('Vistos'),

                    TextInput::make('sacrificados')->numeric()->label('Sacrificados'),

                    TextInput::make('dispersados')->numeric()->label('Dispersados'),

                    TextInput::make('coordenada_x')
                        ->label('Coordenada X')
                        ->numeric()
                        ->step(0.000001)
                        ->disabled()
                        ->dehydrated()
                        ->afterStateHydrated(function (\Filament\Forms\Components\TextInput $component, $state) {
                            if (blank($state)) {
                                $apiKey = config('services.openweathermap.key');
                                $city = 'Panama,PA';

                                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                                    'q' => $city,
                                    'appid' => $apiKey,
                                    'units' => 'metric',
                                ]);

                                if ($response->successful()) {
                                $weather = $response->json();
                                $lat = $weather['coord']['lat'];

                                $lat_formateado = number_format($lat, 8, '.', '');

                                $component->state($lat_formateado);
                                }
                            }
                        }),

                    TextInput::make('coordenada_y')
                        ->label('Coordenada Y')
                        ->numeric()
                        ->step(0.000001)
                        ->disabled()
                        ->dehydrated()
                        ->afterStateHydrated(function (\Filament\Forms\Components\TextInput $component, $state) {
                            if (blank($state)) {
                                $apiKey = config('services.openweathermap.key');
                                $city = 'Panama,PA';

                                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                                    'q' => $city,
                                    'appid' => $apiKey,
                                    'units' => 'metric',
                                ]);
                                if ($response->successful()) {
                                $weather = $response->json();
                                $lon = $weather['coord']['lon'];

                                // Forzar 8 decimales
                                $lon_formateado = number_format($lon, 8, '.', '');

                                $component->state($lon_formateado);
                                }
                            }
                        }),

                    TextInput::make('temperatura')
                    ->numeric()
                    ->label('Temperatura')
                    ->suffix('°C')
                    ->disabled()
                    ->dehydrated()
                    ->afterStateHydrated(function (\Filament\Forms\Components\TextInput $component, $state) {
                            if (blank($state)) {
                                $apiKey = config('services.openweathermap.key');
                                $city = 'Panama,PA';

                                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                                    'q' => $city,
                                    'appid' => $apiKey,
                                    'units' => 'metric',
                                ]);

                                if ($response->successful()) {
                                    $weather = $response->json();
                                    $component->state($weather['main']['temp']);
                                }
                            }
                        }),

                    TextInput::make('viento')
                        ->numeric()
                        ->label('Viento')
                        ->disabled()
                        ->dehydrated()
                        ->suffix('m/s')
                        ->afterStateHydrated(function (\Filament\Forms\Components\TextInput $component, $state) {
                            if (blank($state)) {
                                $apiKey = config('services.openweathermap.key');
                                $city = 'Panama,PA';

                                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                                    'q' => $city,
                                    'appid' => $apiKey,
                                    'units' => 'metric',
                                ]);

                                if ($response->successful()) {
                                    $weather = $response->json();
                                    $component->state($weather['wind']['speed']);
                                }
                            }
                        }),
                    TextInput::make('humedad')
                    ->numeric()
                    ->label('Humedad')
                    ->suffix('%')
                    ->disabled()
                    ->dehydrated()
                    ->afterStateHydrated(function (\Filament\Forms\Components\TextInput $component, $state) {
                            if (blank($state)) {
                                $apiKey = config('services.openweathermap.key');
                                $city = 'Panama,PA';

                                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                                    'q' => $city,
                                    'appid' => $apiKey,
                                    'units' => 'metric',
                                ]);

                                if ($response->successful()) {
                                    $weather = $response->json();
                                    $component->state($weather['main']['humidity']);
                                }
                            }
                        }),
                    FileUpload::make('fotos')
                        ->label('Fotos')
                        ->multiple()
                        ->disk('public')
                        ->directory('intervenciones')
                        ->nullable()
                        ->columnSpan(2),

                    Textarea::make('comentarios')
                        ->label('Comentarios')
                        ->nullable()
                        ->columnSpan(2),
                    ]),
                ])
                //Se guarda en la tabla Intervenciones Draft.
                ->action(function (array $data): void {
                IntervencionesDraft::create([
                ...$data,
                'user_id' => Filament::auth()->id(), // Para luego filtrar solo las del usuario actual.
                ]);
                }),
        ]),
    ]),

]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Usuario'),
                Tables\Columns\TextColumn::make('inicio')->label('Hora de Inicio'),
                Tables\Columns\TextColumn::make('fin')->label('Hora de Finalización'),

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
            // IntervencionesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatrullajes::route('/'),
            'create' => Pages\CreatePatrullaje::route('/create'),
            'edit' => Pages\EditPatrullaje::route('/{record}/edit'),
        ];
    }
}
