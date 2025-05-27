<?php

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
Route::get('/eventoIntervenciones/pdf/{id}', [PDFIntervencionesEvento::class, 'generatePDF'])->name('eventoIntervenciones.pdf');



