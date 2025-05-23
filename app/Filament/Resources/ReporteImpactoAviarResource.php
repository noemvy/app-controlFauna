<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReporteImpactoAviarResource\Pages;
use App\Filament\Resources\ReporteImpactoAviarResource\RelationManagers;
use App\Models\Aerodromo;
use App\Models\Especie;
use App\Models\ReporteImpactoAviar;
use App\Models\PiezaAvion;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Models\Contracts\FilamentUser;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReporteImpactoAviarResource extends Resource
{
    protected static ?string $model = ReporteImpactoAviar::class;

    protected static ?string $navigationIcon = 'lucide-bird';
    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?string $navigationLabel = "Eventos- Impacto con Fauna"; //Nombre en el Panel
    protected static ?string $modelLabel = "Eventos - Impacto con Fauna 🦜";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
/*---------------------------------------------------Sección de Generalidades--------------------------------------------------------------*/
            Forms\Components\Section::make('Generalidades')
            ->description('Datos básicos del incidente')

            ->schema([
                Forms\Components\Select::make('aerodromo_id')
                    ->label('Aeropuerto')
                    ->options(Aerodromo::pluck('nombre', 'id'))
                    ->required()
                    ->default(Filament::auth()->user()->aerodromo_id)
                    ->disabled()
                    ->dehydrated(true),
                Forms\Components\Select::make('pista_id')
                    ->label('Pista')
                    ->options(function ($get) {
                        $aerodromoId = $get('aerodromo_id');
                        if (!$aerodromoId) {
                            return [];
                        }
                        return \App\Models\Pista::where('aerodromo_id', $aerodromoId)
                            ->pluck('nombre', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\DateTimePicker::make('fecha')
                    ->label('Fecha y Hora del incidente')
                    ->seconds(false)
                    ->required()
                    ->maxDate(now()),
            ])->columns(3),
/*---------------------------------------------------SECCION  AERONAVE------------------------------------------------------------------------------*/
                Forms\Components\Section::make('Aeronave')
                ->description('Datos del Avión')
                ->schema([
                //Aerolinea ID
                Forms\Components\Select::make('aerolinea_id')
                ->label('Aerolínea')
                ->relationship(
                    'aerolinea',
                    'nombre',
                    fn($query) =>
                    $query->selectRaw("id, CONCAT(nombre, ' (', tipo, ')') as nombre")
                ),
                 //Modelo ID
                Forms\Components\Select::make('modelo_id')
                    ->relationship('modelo', 'modelo')
                    ->label('Modelo de Aeronave')
                    ->searchable() // Permite buscar entre las opciones
                    ->preload()
                    ->required(),
                //Matricula de Aeronave
                Forms\Components\TextInput::make('matricula')
                    ->label('Matrícula de Aeronave')
                    ->maxLength(255)
                    ->required(),
                //Altitud
                Forms\Components\TextInput::make('Altitud')
                    ->label('Altitud en Metros')
                    ->numeric()
                    ->required(),
                //Velocidad
                Forms\Components\TextInput::make('Velocidad')
                    ->label('Velocidad a la que impactó m/s')
                    ->numeric(),
                ])->columns(3),
/*-----------------------------------------------Condiciones Atmosféricas y de Vuelo---------------------------------------------------------------*/
                Forms\Components\Section::make('Condiciones Atmosféricas y de Vuelo')
                ->description('Datos del Clima y del Vuelo')
                ->schema([
                    Forms\Components\Select::make('Luminosidad')
                    ->options([
                        'Alba' => 'Alba',
                        'Día' => 'Día',
                        'Crepúsculo' => 'Crepúsculo',
                        'Noche' => 'Noche',
                    ])
                    ->required(),
                    Forms\Components\Select::make('Fase_vuelo')
                    ->options([
                        'Rodaje' => 'Rodaje',
                        'Recorrido de Aterrizaje' => 'Recorrido de Aterrizaje',
                        'Carrera de Despegue' => 'Carrera de Despegue',
                        'Taxi' => 'Taxi',
                        'Ascenso' => 'Ascenso',
                        'En ruta' => 'En ruta',
                        'Descenso' => 'Descenso',
                        'Aproximación' => 'Aproximación',
                    ])
                    ->required(),
                    Forms\Components\Select::make('cielo')
                    ->options([
                        'Cielo despejado' => 'Cielo despejado',
                        'Algunas Nubes' => 'Algunas Nubes',
                        'Nublado' => 'Nublado',
                        'Neblina' => 'Neblina',
                        'Lluvia' => 'Luvia'
                    ]),
                    Forms\Components\TextInput::make('temperatura')
                    ->label('temperatura °C')
                    ->numeric(),
                    Forms\Components\TextInput::make('viento_velocidad')
                    ->label('Velocidad del viento m/s')
                    ->numeric(),
                    Forms\Components\Select::make('viento_direccion')
                    ->label('Dirección del viento')
                    ->options([
                        'Este' => 'Este | East',
                        'Este-Noreste' => 'Este-Noreste | East-Northeast',
                        'Este-Sureste' => 'Este-Sureste | East-Southeast',
                        'Noreste' => 'Noreste | Northeast',
                        'Noroeste' => 'Noroeste | Northwest',
                        'Norte' => 'Norte | North',
                        'Norte-Noreste' => 'Norte-Noreste | North-Northeast',
                        'Norte-Noroeste' => 'Norte-Noroeste | North-Northwest',
                        'Oeste' => 'Oeste | West',
                        'Oeste-Noroeste' => 'Oeste-Noroeste | West-Northwest',
                        'Oeste-Suroeste' => 'Oeste-Suroeste | West-Southwest',
                        'Sur' => 'Sur | South',
                        'Sur-Sureste' => 'Sur-Sureste | South-Southeast',
                        'Sur-Suroeste' => 'Sur-Suroeste | South-Southwest',
                        'Sureste' => 'Sureste | Southeast',
                        'Suroeste' => 'Suroeste | Southwest',
                    ]),
                    Forms\Components\Select::make('condicion_visual')
                        ->label('Condición Visual')
                        ->options([
                            'VMC' => 'VMC',
                            'IMC' => 'IMV',
                        ]),
                ])->columns(4),
                Forms\Components\Section::make('Advertencia')
                ->schema([
                    Forms\Components\CheckboxList::make('Advertencia')
                    ->label('¿Fue advertido por tránsito aéreo de la condición por Fauna?')
                    ->options([
                        'Si' => 'Si',
                        'No' => 'No',
                    ])
                    ->required()
                    ]),
                Forms\Components\Section::make('Detalle de Fauna')
                ->description('Detalles de la fauna impactada')
                ->schema([
                Forms\Components\Select::make('especie_id')
                ->label('Especie Impactada')
                ->placeholder('Elija una especie')
                ->options(Especie::all()->pluck('nombre_cientifico','id'))
                ->required()
                ->searchable()
                ->preload(),
                Forms\Components\Select::make('fauna_impactada')
                    ->label('Cantidad de Fauna Impactada')
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
                        '63' => '63 (51–75)',]),
                Forms\Components\Select::make('fauna_observada')
                    ->label('Fauna Observada')
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
                        '63' => '63 (51–75)',]),
                Forms\Components\Select::make('fauna_tamano')
                    ->label('Tamaño de las Especies')
                    ->options([
                        'pequeñas' => 'Pequeñas',
                        'medianas' => 'Medianas',
                        'grandes' => 'Grandes',
                    ]),
                Forms\Components\FileUpload::make('img_paths_fauna')
                    ->label('Imágenes de Fauna')
                    ->multiple() // Permite subir múltiples archivos
                    ->maxFiles(5)
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->directory('imagenes/impacto_aviar')
                    ->columnSpanFull()
                    ->storeFiles() // Guarda los archivos correctamente en el storage
                    ->saveUploadedFileUsing(fn($file) => $file->store('imagenes/impacto_aviar', 'public'))
                    ->afterStateHydrated(function ($state) {
                        // Si el estado es JSON, lo convertimos a array
                        return is_string($state) ? json_decode($state, true) : (is_array($state) ? $state : []);
                    }),
                ])->columns(2),

                /*-----------------------------SECCION AFECTADA--------------------------------------------------*/
                Forms\Components\Section::make('Piezas Afectadas')
                ->schema([
                Forms\Components\Select::make('partes_golpeadas')
                ->label('Piezas de la Aeronave Golpeadas')
                ->multiple()
                ->relationship('partesGolpeadas', 'nombre') // Asocia la relación con la columna 'nombre'
                ->options(PiezaAvion::pluck('nombre', 'id')->toArray()) // Carga todas las piezas disponibles
                ->searchable()
                ->required(),
                Forms\Components\Select::make('partes_danadas')
                ->label('Piezas de la Aeronave Dañadas')
                ->multiple()
                ->relationship('partesDanadas', 'nombre') // Asocia la relación con la columna 'nombre'
                ->options(PiezaAvion::pluck('nombre', 'id')->toArray()) // Carga todas las piezas disponibles
                ->searchable(),
                Forms\Components\FileUpload::make('img_paths_impacto')
                ->label('Imágenes de Impacto')
                ->multiple() // Permite múltiples archivos
                ->maxFiles(5)
                ->image() // Solo permite imágenes
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->directory('imagenes/impacto_aviar') // Directorio donde se almacenan los archivos
                ->columnSpanFull()
                ->storeFiles() // Asegura que los archivos se guarden correctamente
                ->saveUploadedFileUsing(fn($file) => $file->store('imagenes/impacto_aviar', 'public'))
                ->afterStateHydrated(function ($state) {
                    // Si el estado es JSON, lo convertimos a array, si es array lo dejamos como está, si no es válido, devolvemos un array vacío
                    return is_string($state) ? json_decode($state, true) : (is_array($state) ? $state : []);
                })
                ->dehydrateStateUsing(function ($state) {
                    // Antes de guardar en la base de datos, aseguramos que sea un JSON string válido
                    return json_encode(is_array($state) ? $state : []);
                })
                ])->columns(4),


                /*----------------------SECCION AFECTACIONES----------------------------------- */
                Forms\Components\Section::make('Afectaciones')
                ->schema([
                Forms\Components\Select::make('consecuencia')
                ->label('Consecuencia para el vuelo')
                ->options([
                    'No hubo consecuencias' => 'No hubo consecuencias',
                    'Despegue Interrumpido (RTO)' => 'Despegue Interrumpido (RTO)',
                    'Aterrizaje con Precaución (ATB)' => 'Aterrizaje con Precaución (ATB)',
                    'Se apagaron motores' => 'Se apagaron motores',
                    'Retorno a Puente (GTB)' => 'Retorno a Puente (GTB)',
                    'Retraso de Vuelo' => 'Retraso de Vuelo',
                    'Otros' => 'Otros | Others',
                ])
                ->required(),
                Forms\Components\TextInput::make('tiempo_fs')
                ->label('Tiempo de la aeronave fuera de servicio (Horas)')
                ->numeric(),
                Forms\Components\TextInput::make('costo_reparacion')
                ->label('Costo estimado en reparaciones o reemplazo de piezas (Dólares o Balboas)')
                ->numeric(),
                Forms\Components\TextInput::make('costo_otros')
                ->label('otros costo estimados. Ejemp: combustible, hoteles, etc. (Dólares o Balboas)')
                ->numeric(),
                ])->columns(2),
                /*--------------------------------------SECCION COMENTARIOS--------------------------------------------*/
                Forms\Components\Section::make('Comentarios')
                ->schema([
                Forms\Components\Textarea::make('observacion')
                ->label('Observaciones Generales')
                ->columnSpanFull(),
                ]),
                /*----------------------SECCION REPORTADOR POR--------------------------------------------------------*/
                Forms\Components\Section::make('Reportado por')
                ->schema([
                Forms\Components\Select::make('email')
                ->label('Correo Electronico')
                ->options(User::pluck('email','email'))
                ->default(Filament::auth()->user()?->email)
                ->disabled()
                ->dehydrated(),
                ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReporteImpactoAviars::route('/'),
            'create' => Pages\CreateReporteImpactoAviar::route('/create'),
            'edit' => Pages\EditReporteImpactoAviar::route('/{record}/edit'),
        ];
    }
}
