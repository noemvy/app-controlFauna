<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/report/pdf/{id}', [PDFController::class, 'generatePDF'])->name('report.pdf');



