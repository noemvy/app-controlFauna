<?php

namespace App\Filament\Resources\PatrullajeResource\Widgets;

use App\Models\IntervencionesEventoDraft;
use App\Models\Patrullaje;
use App\Models\ReporteImpactoAviar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatrullajeStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Patrullajes', Patrullaje::query()->count())
            ->description('Todos los Patrullajes')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning'),


            Stat::make('Reporte Impacto Aviar', ReporteImpactoAviar::query()->count())
            ->description('Eventos Tipo: Reporte IFA')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('info'),

            Stat::make('Intervenciones en Eventos',IntervencionesEventoDraft::query()->count())
            ->description('Eventos Tipo: Dispersión / Recogida')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('primary'),
        ];
    }
}
