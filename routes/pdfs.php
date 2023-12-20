<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/matricular/{id}', [PdfController::class, 'matri']);
Route::get('/certificado/{id}', [PdfController::class, 'certificado']);
Route::get('/cobro/{id}', [PdfController::class, 'cobro']);
