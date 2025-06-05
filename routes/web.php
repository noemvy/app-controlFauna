<?php

use App\Http\Controllers\EfectividadController;
use App\Http\Controllers\EspeciesStatsController;
use App\Http\Controllers\MunicionesStatsController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PDFIntervencionesEvento;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//Ruta para el reporte de Impacto con Fauna
Route::get('/report/pdf/{id}', [PDFController::class, 'generatePDF'])->name('report.pdf');

//Ruta para el reporte de evento intervenciones
Route::get('/eventoIntervenciones/pdf/{id}', [PDFIntervencionesEvento::class, 'generatePDF'])
->name('eventoIntervenciones.pdf');


Route::get('/estadisticas-especies/export-excel', [EspeciesStatsController::class, 'exportExcel'])
->name('estadisticas.especies.export-excel');


Route::get('/estadisticas-municiones/export-excel', [MunicionesStatsController::class, 'exportExcel'])
->name('estadisticas.municiones.export-excel');


Route::get('/estadisticas-efectividad/export-excel', [EfectividadController::class, 'exportExcel'])
->name('estadisticas.efectividad.export-excel');
