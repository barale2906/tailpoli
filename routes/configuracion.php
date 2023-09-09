<?php

use Illuminate\Support\Facades\Route;

Route::get('/estados', function () {
    return view('configuracion.estados.index');
})->name('estados');

Route::get('/country', function () {
    return view('configuracion.countries.index');
})->name('ubicacionCountry');

Route::get('/areas', function () {
    return view('configuracion.areas.index');
})->name('ubicacionAreas');
