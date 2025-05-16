<?php

namespace App\Filament\Resources\PatrullajeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\Textarea;

class IntervencionesRelationManager extends RelationManager
{
    protected static string $relationship = 'intervenciones';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('especies_id')
                ->label('Especie')
                ->relationship('especie', 'nombre') // Asegúrate de que 'nombre' exista
                ->searchable()
                ->required(),

            Select::make('catinventario_id')
                ->label('Catálogo Inventario')
                ->relationship('catalogoInventario', 'nombre') // Revisa campo 'nombre'
                ->searchable()
                ->required(),

            Select::make('acciones_id')
                ->label('Acción')
                ->relationship('accion', 'nombre') // Revisa campo 'nombre'
                ->searchable()
                ->required(),

            Select::make('atractivos_id')
                ->label('Atractivo')
                ->relationship('atractivo', 'nombre') // Revisa campo 'nombre'
                ->searchable()
                ->required(),

            Toggle::make('guardado')->label('Guardado'),

            TextInput::make('reportable_type')
                ->label('Tipo de Reporte')
                ->required(),

            TextInput::make('reportable_id')
                ->label('ID del Reporte')
                ->required(),

            TextInput::make('vistos')->numeric()->label('Vistos'),
            TextInput::make('sacrificados')->numeric()->label('Sacrificados'),
            TextInput::make('dispersados')->numeric()->label('Dispersados'),

            TextInput::make('coordenada_x')
                ->label('Coordenada X')
                ->numeric()
                ->step(0.000001),

            TextInput::make('coordenada_y')
                ->label('Coordenada Y')
                ->numeric()
                ->step(0.000001),

            FileUpload::make('fotos')
                ->label('Fotos')
                ->multiple()
                ->disk('public')
                ->directory('intervenciones')
                ->preserveFilenames()
                ->reorderable()
                ->nullable(),

            TextInput::make('temperatura')->numeric()->label('Temperatura'),
            TextInput::make('viento')->numeric()->label('Viento'),
            TextInput::make('humedad')->numeric()->label('Humedad'),

            Textarea::make('comentarios')->label('Comentarios')->nullable(),
        ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('intervenciones')
            ->columns([
                Tables\Columns\TextColumn::make('intervenciones'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    

}
