<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/matricular/{id}', [PdfController::class, 'matri']);
Route::get('/certificado/{id}', [PdfController::class, 'certificado']);
Route::get('/cobro/{id}', [PdfController::class, 'cobro']);
Route::get('/estado/{id}', [PdfController::class, 'estado']);

Route::get('/contrato/{id}', [PdfController::class, 'contrato']);
Route::get('/pagaret/{id}', [PdfController::class, 'pagaret']);
Route::get('/cartapag/{id}', [PdfController::class, 'cartapag']);
Route::get('/actap/{id}', [PdfController::class, 'actap']);
Route::get('/comprocred/{id}', [PdfController::class, 'comprocred']);
Route::get('/comproent/{id}', [PdfController::class, 'comproent']);
Route::get('/gastocert/{id}', [PdfController::class, 'gastocert']);
Route::get('/matricul/{id}', [PdfController::class, 'matricul']);
