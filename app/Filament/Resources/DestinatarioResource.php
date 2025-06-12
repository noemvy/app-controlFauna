<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinatarioResource\Pages;
use App\Filament\Resources\DestinatarioResource\RelationManagers;
use App\Models\Destinatario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DestinatarioResource extends Resource
{
    protected static ?string $model = Destinatario::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationLabel = 'Destinatarios';
    protected static ?string $navigationGroup = 'Catálogos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('correo')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'Para' => 'Para',
                        'CC' => 'CC',
                        'CCO' => 'CCO',
                    ])
                    ->required(),

                Forms\Components\Select::make('formulario')
                    ->label('Formulario')
                    ->options([
                        'RCR' => 'RCR',
                        'IFA' => 'IFA',
                    ])
                    ->default('')
                    ->required(),

                Forms\Components\TextInput::make('autor')
                    ->label('Autor')
                    ->disabled()
                    ->default(fn() => Auth::user()->name ?? 'Desconocido'),

                Forms\Components\Select::make('aerodromos')
                    ->label('Aeropuertos Asociados')
                    ->multiple()
                    ->relationship('aerodromos', 'nombre')
                    ->options(\App\Models\Aerodromo::pluck('nombre', 'id')->toArray()) // Carga todos los aeropuertos
                    ->required(),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ])
                    ->default(1) // Valor por defecto establecido como "Activo"
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('correo')->label('Correo Electrónico')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tipo')->label('Tipo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('formulario')->label('Formulario')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('estado')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle') // Ícono para verdadero
                    ->falseIcon('heroicon-o-x-circle') // Ícono para falso
                    ->trueColor('success') // Color para verdadero
                    ->falseColor('danger'), // Color para falso
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
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
            'index' => Pages\ListDestinatarios::route('/'),
            'create' => Pages\CreateDestinatario::route('/create'),
            'edit' => Pages\EditDestinatario::route('/{record}/edit'),
        ];
    }
}
