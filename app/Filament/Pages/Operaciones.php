<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Evento;
use App\Models\Patrullaje;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventoResource;
use Filament\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;

class Operaciones extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.operaciones';
    public static ?string $navigationGroup = 'Operaciones';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([

                Tables\Columns\TextColumn::make('aerodromo.nombre')
                    ->label('Aeródromo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tipo_evento')
                    ->label('Tipo de Evento')
                    ->searchable(),

                Tables\Columns\TextColumn::make('comentario')
                    ->label('Comentario')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Evento')
                    ->sortable()
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->url(fn (Evento $record): string => EventoResource::getUrl('edit', ['record' => $record])),
            ])
            ->bulkActions([]);
    }


    protected function getTableQuery(): Builder
    {
        return Evento::query();
        return Patrullaje::query();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('crear_evento')
                ->label('Crear Evento')
                ->url(EventoResource::getUrl('create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
