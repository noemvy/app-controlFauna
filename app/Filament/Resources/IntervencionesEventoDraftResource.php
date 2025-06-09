<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntervencionesEventoDraftResource\Pages;
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
use Filament\Forms\Components\View;

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
/*--------------------------------------------------Datos del Evento----------------------------------*/
    Forms\Components\Section::make('Datos del Evento')
    ->schema([
    Forms\Components\Select::make('tipo_evento')
        ->label('Tipo de Evento')
        ->options([
            'Dispersión'=>'Dispersión',
            'Recogida' => 'Recogida'
        ])
        ->required(),
    Forms\Components\Select::make('origen')
        ->label('Origen del Reporte')
        ->options([
            'TWR' => 'TWR',
            'SSEI'=>'SSEI',
            'AVSEC'=>'AVSEC',
        ])
        ->required(),
    ])->columns(2),
/*-----------------------------------------Datos de las especies🦜--------------------------------------*/
    Forms\Components\Section::make('Datos de la Fauna')
    ->schema([
    Forms\Components\Select::make('grupos_id')
        ->label('Grupo')
        ->options(Grupo::orderBy('nombre')->pluck('nombre', 'id'))
        ->reactive()
        ->required()
        ->afterStateUpdated(fn (callable $set) => $set('especies_id', null)),
    Forms\Components\Select::make('especies_id')
        ->label('Especie')
        ->searchable()->required()
        ->disabled(fn (callable $get) => !$get('grupos_id'))
        ->options(function (callable $get,  $record) {
        $grupoId = $get('grupos_id');
        if (!$grupoId && !$record) {
            return [];
        }
        $query = Especie::query();
        if ($grupoId) {
            $query->where('grupos_id', $grupoId);
        }
        // Si estamos editando un registro, aseguramos que su especie también se incluya en la lista
        if ($record && $record->especies_id) {
            $query->orWhere('id', $record->especies_id);
        }
        return $query->orderBy('nombre_cientifico')->pluck('nombre_cientifico', 'id');
        }),
    Forms\Components\Select::make('atractivos_id')
        ->label('Atractivo para la Fauna')
        ->options(Atractivo::pluck('nombre', 'id'))->searchable()->required(),
    Forms\Components\Select::make('vistos')
        ->options(self::getCantidadOptions())->label('Vistos')->placeholder('Seleccione una cantidad'),
    Forms\Components\Select::make('sacrificados')
        ->label('Sacrificados')
        ->options(self::getCantidadOptions())->placeholder('Seleccione una cantidad'),
    Forms\Components\Select::make('dispersados')
        ->label('Dispersados')
        ->options(self::getCantidadOptions())->placeholder('Seleccione una cantidad'),
    Forms\Components\FileUpload::make('fotos')
        ->label('Fotos')
        ->multiple()->maxFiles(5)
        ->image()->disk('public')
        ->directory('intervenciones')
        ->preserveFilenames()->reorderable()->nullable()
        ->columnSpanFull(),
    ])->columns(3),
/*-----------------------------------------Datos del clima⛅--------------------------------------------*/
    Forms\Components\Section::make('Datos del Clima y Ubicación')
        ->schema([
        Forms\Components\TextInput::make('coordenada_x')
        ->label('Coordenada X')
        ->id('coordenada_x')->readOnly()->dehydrated(2),
    Forms\Components\TextInput::make('coordenada_y')
        ->label('Coordenada Y')
        ->id('coordenada_y')->readOnly()->dehydrated(true),
    View::make('components.get-coordenadas'),
    Forms\Components\TextInput::make('temperatura')
        ->label('Temperatura')
        ->suffix('°C')->disabled()->dehydrated(true)
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
    Forms\Components\Grid::make(4) // Agrupamos en una fila de 4 columnas
        ->schema([
    Forms\Components\Select::make('aerodromo_id')
        ->label('Aeropuerto')
        ->options(Aerodromo::pluck('nombre', 'id'))->required()
        ->default(Filament::auth()->user()->aerodromo_id)
        ->disabled()->dehydrated(true),
    Forms\Components\Select::make('catinventario_id')
        ->label('Herramienta Utilizada:')
        ->options(CatalogoInventario::pluck('nombre', 'id'))->searchable()
        ->reactive()->required()->dehydrated()
        ->afterStateUpdated(function (callable $set, $state) {
            $inventario = CatalogoInventario::find($state);
            $set('acciones_id', $inventario?->acciones_id);
            $set('es_consumible', $inventario?->es_consumible);
        }),
    Forms\Components\Select::make('acciones_id')
        ->label('Tipo de Acción Realizada:')
        ->options(Acciones::pluck('nombre', 'id'))
        ->searchable()->required()->disabled()->dehydrated(true),
    Forms\Components\Hidden::make('es_consumible')
        ->dehydrated(false),
    Forms\Components\TextInput::make('cantidad_utilizada')
        ->label('Cantidad a utilizar')->numeric()
        ->required(fn (callable $get) => $get('es_consumible') === 1)
        ->visible(fn (callable $get) => $get('es_consumible') === 1),
        ]),
    ])
    ->defaultItems(1)
    ->reorderable(false)
    ])
    ->columns(1)
    ->columnSpanFull(),
/*----------------------------------------------------------------SECCION COMENTARIOS-------------------------------------------------*/
    Forms\Components\Section::make('Comentarios y Usuario')
        ->schema([
    Forms\Components\Textarea::make('comentarios')->label('Comentarios')->nullable(),
    Forms\Components\Select::make('user_id')->label('Usuario')
        ->options(User::pluck('name', 'id'))->required()
        ->default(Filament::auth()->id())->disabled()->dehydrated(true),
        ]),
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
    ])->defaultSort('created_at', 'desc')
    ->filters([
    //FILTROS PARA BUSQUEDA
    Tables\Filters\SelectFilter::make('origen')->label('Origen')
    ->options([
        'TWR' => 'TWR',
        'SSEI'=>'SSEI',
        'AVSEC'=>'AVSEC',
    ]),
    Tables\Filters\SelectFilter::make('tipo_evento')->label('Tipo Evento')
    ->options([
        'Dispersión'=>'Dispersión',
        'Recogida' => 'Recogida',
    ])
    ])->searchable()
    ->actions([
    //Ventanita para las actualizaciones.
    Tables\Actions\Action::make('actualizaciones')
    ->label('Actualizaciones')
    ->icon('heroicon-o-eye')
    ->modalHeading('Actualizaciones del Reporte')
    ->form([
    Forms\Components\Textarea::make('actualizacion')
        ->label('Añadir Nueva Actualización')
        ->rows(4)->required(),
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
//Funcion para los campos vistos, dispersados, sacrificados. para no volver repetitivo el codigo.
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
