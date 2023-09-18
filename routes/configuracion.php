<?php

use Illuminate\Support\Facades\Route;

Route::get('/estados', function () {
    return view('configuracion.estados.index');
})->middleware('can:estados')->name('estados');

Route::get('/country', function () {
    return view('configuracion.countries.index');
})->middleware('can:countrys')->name('ubicacionCountry');

Route::get('/areas', function () {
    return view('configuracion.areas.index');
})->middleware('can:areas')->name('ubicacionAreas');

Route::get('/sedes', function () {
    return view('configuracion.sedes.index');
})->middleware('can:sedes')->name('sedes');
