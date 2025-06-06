<?php

namespace App\Providers\Filament;

use App\Filament\Resources\PatrullajeResource\Widgets\PatrullajeStats;
use App\Filament\Widgets\EstadisticaEspeciesChart;
use App\Filament\Widgets\MunicionesChart;
use App\Filament\Widgets\MunicionesPorEspecieChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->favicon(asset('images/favicon.png'))
            ->brandLogo(asset('images/logo-fauna.png'))
            ->brandLogoHeight('60px')
            ->colors([
                    'danger' => Color::Red,
                    'gray' => Color::Zinc,
                    'info' => Color::Blue,
                    'blue' => Color::Blue,
                    'primary' => Color::Lime,
                    'success' => Color::Green,
                    'warning' => Color::Amber,
            ])
            ->widgets([
                PatrullajeStats::class,
                EstadisticaEspeciesChart::class,
                MunicionesPorEspecieChart::class,
                MunicionesChart::class,

            ])
            ->darkMode(false)
            ->renderHook('panels::body.start', fn()=>'
            <style>
                .fi-sidebar{
                background-color:#90d652;
                }

                /*-------- -----------Sidebar: texto de los menús---------------- */
                .fi-sidebar-item-label {
                font-weight: 700 !important;
                color: #0D4715 !important;
                }

                /*------------------Cambiar el color a los grupos ejemplos: Operaciones ,Catalogos-----------------------*/
                .fi-sidebar-group-label {
                font-weight: 700 !important;
                color: #0D4715 !important;
                }

                /*---------------Cambiar color del ícono/flechita del grupo de navegación--------------------*/
                    .fi-icon-btn {
                        color: #0D4715; /* Por ejemplo, un púrpura bonito */
                        stroke-width: 2.5;
                    }
                /*-------------------------Cambiar el color de los iconos---------------------------*/
                /* Sidebar: íconos */
                .fi-sidebar-item-icon {
                font-weight: 700 !important;
                color: #0D4715 !important;
                stroke-width: 2.5; /* Más grueso para íconos tipo SVG */
                }


                /* Estilos para la sección .fi-section-heaction */
                .fi-section-header {
                    background-color: #F1F0E8;
                    padding: 1rem;
                    font-weight: 700;
                }

                .fi-notification {
                    font-size: 1rem; /* Tamaño de texto */
                    padding: 1rem;
                }
                /* Estilo general de la notificación */
                .fi-notification {
                    font-size: 1.05rem;
                    padding: 1.25rem;
                    border-radius: 12px;
                }

                /* Estilo del título de la notificación */
                .fi-notification .fi-notification-title {
                    font-size: 1.25rem;
                    font-weight: 700; /* Negrita */
                }

                /* Estilo del cuerpo (mensaje) de la notificación */
                .fi-notification .fi-notification-body {
                    font-size: 1.1rem;
                    font-weight: 600; /* Semi-negrita */
                }

                /* Personalización opcional por tipo */
                .fi-notification[data-theme="warning"] {
                    background-color: #fef08a !important;
                    color: #78350f !important;
                }
            </style>
            ')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class, // <- Esto debe apuntar a tu Dashboard
            ])

            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
