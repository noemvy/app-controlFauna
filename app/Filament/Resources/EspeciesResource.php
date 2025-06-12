<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EspeciesResource\Pages;
use App\Filament\Resources\EspeciesResource\RelationManagers;
use App\Models\Especie;
use App\Models\Grupo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EspeciesResource extends Resource
{
    protected static ?string $model = Especie::class;

    protected static ?string $navigationIcon = 'lucide-flag';
    protected static ?string $navigationGroup = 'Catálogos';
    protected static ?string $navigationLabel = "Especies";
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('grupos_id')
                ->label('Grupo de la Especie')
                ->options(Grupo::orderBy('nombre')->pluck('nombre', 'id'))
                ->required(),
                Forms\Components\TextInput::make('nombre_comun')
                ->label('Nombre Común')
                ->required(),
                Forms\Components\TextInput::make('nombre_cientifico')
                ->label('Nombre Científico')
                ->required(),
                Forms\Components\Select::make('rango_peligrosidad')
                ->label('Rango de Peligro')
                ->options([
                    'Bajo' => 'Bajo',
                    'Moderado' => 'Moderado',
                    'Alto' => 'Alto',
                    'Muy Alto' =>'Muy Alto',
                ])
                ->required(),
                Forms\Components\FileUpload::make('foto')
                ->label('Foto de la Especie')->multiple()
                ->maxFiles(1)->image()
                ->disk('public')->directory('especies')
                ->preserveFilenames()->reorderable()
                ->nullable()->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('grupo.nombre')->label('Grupo'),
                Tables\Columns\TextColumn::make('nombre_cientifico')->label('Especie')
                ->searchable()
            ])->defaultSort('created_at', 'desc')
            ->filters([
            Tables\Filters\SelectFilter::make('grupo.nombre')->label('Grupo de Especie')
            ->options(Grupo::orderBy('nombre')->pluck('nombre', 'id'))
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
            'index' => Pages\ListEspecies::route('/'),
            'create' => Pages\CreateEspecies::route('/create'),
            'edit' => Pages\EditEspecies::route('/{record}/edit'),
        ];
    }
}
