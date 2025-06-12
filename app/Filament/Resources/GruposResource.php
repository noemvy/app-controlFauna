<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GruposResource\Pages;
use App\Filament\Resources\GruposResource\RelationManagers;
use App\Models\Grupo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GruposResource extends Resource
{
    protected static ?string $model = Grupo::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationLabel = "Grupo de Animales";
    protected static ?string $navigationGroup = 'Catálogos';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                ->label('Grupo de animales')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Grupo Animal')->searchable()->sortable()
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
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
            'index' => Pages\ListGrupos::route('/'),
            'create' => Pages\CreateGrupos::route('/create'),
            'edit' => Pages\EditGrupos::route('/{record}/edit'),
        ];
    }
}
