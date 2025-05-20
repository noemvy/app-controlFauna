<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntervencionesResource\Pages;
use App\Filament\Resources\IntervencionesResource\RelationManagers;
use App\Models\Intervenciones;
use App\Models\User;
use App\Models\Grupo;
use App\Models\Especie;
use App\Models\CatalogoInventario;
use App\Models\Acciones;
use App\Models\Atractivo;
use App\Models\IntervencionesDraft;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Model;
use Filament\Tables;
use Filament\Tables\Table;

class IntervencionesResource extends Resource
{
    protected static ?string $model = Intervenciones::class;

    protected static ?string $navigationIcon = 'lucide-siren';
    protected static ?string $navigationGroup = 'Operaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

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
            'index' => Pages\ListIntervenciones::route('/'),
            'create' => Pages\CreateIntervenciones::route('/create'),
            'edit' => Pages\EditIntervenciones::route('/{record}/edit'),
        ];
    }
}
