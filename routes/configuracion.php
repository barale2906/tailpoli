<?php

use Illuminate\Support\Facades\Route;

Route::get('/estados', function () {
    return view('configuracion.estados.index');
})->name('estados');
