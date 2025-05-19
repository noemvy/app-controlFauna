<?php

namespace App\Filament\Resources\PatrullajeResource\Widgets;

use App\Models\Patrullaje;
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
            ->color('success'),
        ];
    }
}
