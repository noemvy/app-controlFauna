<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtractivosResource\Pages;
use App\Filament\Resources\AtractivosResource\RelationManagers;
use App\Models\Atractivo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AtractivosResource extends Resource
{
    protected static ?string $model = Atractivo::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Catálogos';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('nombre')
                ->label('Atractivo para la fauna')
                ->options([
                    'Vertederos de basura' => 'Vertederos de basura',
                    'Fuentes de agua estancada' => 'Fuentes de agua estancada',
                    'Cultivos cercanos' => 'Cultivos cercanos',
                    'Presencia de insectos' => 'Presencia de insectos',
                    'Lagunas o ríos' => 'Lagunas o ríos',
                    'Áreas de vegetación densa' => 'Áreas de vegetación densa',
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Tipo de Atractivo')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAtractivos::route('/'),
            'create' => Pages\CreateAtractivos::route('/create'),
            'edit' => Pages\EditAtractivos::route('/{record}/edit'),
        ];
    }
}
