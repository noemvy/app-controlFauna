<?php

namespace App\Filament\Pages;

use App\Models\CatalogoInventario;
use App\Models\Especie;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use Filament\Forms;
use Illuminate\Support\Facades\URL;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportar')
                ->label('Exportar estadísticas')
                ->icon('lucide-file-x-2')
                ->color('info')
                ->form([
                    Forms\Components\Section::make('Tiempo')
                        ->schema([
                            Forms\Components\Select::make('filtro_fecha')
                                ->label('Especies')
                                ->options([
                                    'hoy' => 'Hoy',
                                    'semana' => 'Esta semana',
                                    'mes' => 'Este mes',
                                    'ano' => 'Este año',
                                    'todos' => 'Todos',
                                ])
                                ->placeholder('Especie vista...')
                                ->reactive()
                                ->disabled(fn ($get) =>
                                    !empty($get('fecha_municiones')) || !empty($get('opcion'))
                                ),

                            Forms\Components\Select::make('fecha_municiones')
                                ->label('Municiones')
                                ->options([
                                    'hoy' => 'Hoy',
                                    'semana' => 'Esta semana',
                                    'mes' => 'Este mes',
                                    'ano' => 'Este año',
                                    'todos' => 'Todos',
                                ])
                                ->placeholder('Equipos usados...')
                                ->reactive()
                                ->disabled(fn ($get) =>
                                    !empty($get('fecha_municiones')) || !empty($get('opcion'))
                                ),

                        ]),

                    Forms\Components\Section::make('Rango de Fecha')
                        ->description('Selecciona si deseas generar el reporte de Especies o Municiones y Elige un Rango de Fecha')
                        ->schema([
                            Forms\Components\Radio::make('opcion')
                                ->label('Elige un rango de fecha para:')
                                ->options([
                                    'especie' => 'Especie',
                                    'municion' => 'Munición',
                                ])
                                ->reactive()
                                ->disabled(fn ($get) =>!empty($get('filtro_fecha')) || !empty($get('opcion'))),

                            Forms\Components\DatePicker::make('fecha_inicio')
                                ->label('Fecha inicio')
                                ->placeholder('Selecciona fecha inicio')
                                ->required(false)
                                ->reactive()
                                ->disabled(fn ($get) =>!empty($get('filtro_fecha')) || !empty($get('fecha_municiones'))),

                            Forms\Components\DatePicker::make('fecha_fin')
                                ->label('Fecha fin')
                                ->placeholder('Selecciona fecha fin')
                                ->required(false)
                                ->reactive()
                                ->disabled(fn ($get) =>!empty($get('filtro_fecha')) || !empty($get('fecha_municiones'))),
                        ])
                ])
                ->action(function (array $data) {
                    $params = [];
                    // Si hay rango de fechas y opción seleccionada
                    if ((!empty($data['fecha_inicio']) || !empty($data['fecha_fin'])) && !empty($data['opcion'])) {
                        if (!empty($data['fecha_inicio'])) {
                            $params['fecha_inicio'] = $data['fecha_inicio'];
                        }
                        if (!empty($data['fecha_fin'])) {
                            $params['fecha_fin'] = $data['fecha_fin'];
                        }

                        $query = http_build_query($params);

                        if ($data['opcion'] === 'especie') {
                            return redirect()->away(URL::route('estadisticas.especies.export-excel') . '?' . $query);
                        } elseif ($data['opcion'] === 'municion') {
                            return redirect()->away(URL::route('estadisticas.municiones.export-excel') . '?' . $query);
                        }
                    }
                    // Si no hay rango de fechas, usamos los selects normales
                    // Lógica para municiones si seleccionó filtro
                    if (!empty($data['fecha_municiones'])) {
                        $params['fecha_municiones'] = $data['fecha_municiones'];
                        $query = http_build_query($params);
                        return redirect()->away(URL::route('estadisticas.municiones.export-excel') . '?' . $query);
                    }
                    // Por defecto para especies
                    $params['filtro_fecha'] = $data['filtro_fecha'] ?? 'todos';
                    $query = http_build_query($params);
                    return redirect()->away(URL::route('estadisticas.especies.export-excel') . '?' . $query);
                }),


                Action::make('efectividad')
                ->label('Efectividad De Municiones')
                ->icon('lucide-target')
                ->color('warning')
                ->form([
                    Forms\Components\Select::make('especie_id')
                        ->label('Especie')
                        ->options(Especie::pluck('nombre_cientifico','id'))
                        ->searchable()
                        ->placeholder('Todas las especies...'),

                    Forms\Components\Select::make('municion_id')
                        ->label('Munición')
                        ->options(CatalogoInventario::pluck('nombre','id'))
                        ->searchable()
                        ->placeholder('Todas las municiones...'),
                ])
                ->action(function (array $data) {
                    $params = [];

                    if (!empty($data['especie_id'])) {
                        $params['especie_id'] = $data['especie_id'];
                    }

                    if (!empty($data['municion_id'])) {
                        $params['municion_id'] = $data['municion_id'];
                    }

                    $query = http_build_query($params);

                    return redirect()->away(URL::route('estadisticas.efectividad.export-excel') . '?' . $query);
                }),

        ];
    }
}
