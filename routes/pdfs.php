<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/matricular/{id}', [PdfController::class, 'matri']);
