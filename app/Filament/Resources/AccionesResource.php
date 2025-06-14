<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccionesResource\Pages;
use App\Filament\Resources\AccionesResource\RelationManagers;
use App\Models\Acciones;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccionesResource extends Resource
{
    protected static ?string $model = Acciones::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationLabel = 'Acciones';
    protected static ?string $navigationGroup = 'Catálogos';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                ->label('Nueva Acción')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('nombre')->label('Acciones')->searchable()->sortable(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([

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
            'index' => Pages\ListAcciones::route('/'),
            'create' => Pages\CreateAcciones::route('/create'),
            'edit' => Pages\EditAcciones::route('/{record}/edit'),
        ];
    }
}
