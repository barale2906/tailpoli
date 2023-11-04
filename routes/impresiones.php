<?php

use Illuminate\Support\Facades\Route;

Route::get('/imprecibo', function () {
    return view('impresiones.imprecibo');
})->name('imprecibo');
