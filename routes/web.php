<?php

use App\Http\Controllers\EfectividadController;
use App\Http\Controllers\EspeciesStatsController;
use App\Http\Controllers\MunicionesStatsController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PDFIntervencionesEvento;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
//Ruta para el reporte de Impacto con Fauna
Route::get('/report/pdf/{id}', [PDFController::class, 'generatePDF'])->name('report.pdf');

//Ruta para el reporte de evento intervenciones
Route::get('/eventoIntervenciones/pdf/{id}', [PDFIntervencionesEvento::class, 'generatePDF'])
->name('eventoIntervenciones.pdf');


//Ruta para las estadisiticas de especies vistas
Route::get('/estadisticas-especies/export-excel', [EspeciesStatsController::class, 'exportExcel'])
->name('estadisticas.especies.export-excel');

//Ruta para las estadisicticas de municiones
Route::get('/estadisticas-municiones/export-excel', [MunicionesStatsController::class, 'exportExcel'])
->name('estadisticas.municiones.export-excel');

//Ruta para descargar el excel de efectividad de municiones en relacion de la especie.
Route::get('/estadisticas-efectividad/export-excel', [EfectividadController::class, 'export'])
->name('estadisticas.efectividad.export-excel');

//Ruta para ver los detalles del patrullaje junto con las intervenciones realizadas.
Route::middleware(['auth'])->group(function () {
    Route::get('/patrullajes/{patrullaje}', [\App\Http\Controllers\DetallePatrullajeController::class, 'show'])
        ->name('patrullajes.show');
});

