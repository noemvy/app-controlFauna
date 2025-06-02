<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsuariosResource\Pages;
use App\Filament\Resources\UsuariosResource\RelationManagers;
use App\Models\Aerodromo;
use App\Models\Departamento;
use App\Models\User;
use App\Models\Usuarios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsuariosResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Usuarios';
    protected static ?string $modelLabel = 'Usuarios';
    protected static ?int $navigationSort = 999; 
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('password')
                ->required()
                ->label('Contraseña'),
            Forms\Components\TextInput::make('codigo_colaborador')
                ->label('Código de Colaborador')
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Forms\Components\Toggle::make('estado')
                ->label('Activo')
                ->helperText('Marca si el usuario está activo.'),

            Forms\Components\Select::make('aerodromo_id')
                    ->label('Aeródromo')
                    ->relationship('aerodromo', 'nombre')
                    ->required(),

            Forms\Components\Select::make('departamento_id')
                    ->label('Departamento')
                    ->relationship('departamento', 'descripcion')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\TextColumn::make('estado')->label('Activo'),
            Tables\Columns\TextColumn::make('aerodromo.nombre')->label('Aeródromo')->sortable(),
            Tables\Columns\TextColumn::make('departamento.nombre')->label('Departamento')->sortable(),
            ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListUsuarios::route('/'),
            'create' => Pages\CreateUsuarios::route('/create'),
            'edit' => Pages\EditUsuarios::route('/{record}/edit'),
        ];
    }
}
