<?php

use Illuminate\Support\Facades\Route;

Route::get('/estados', function () {
    return view('configuracion.estados.index');
})->middleware('can:co_estados')->name('estados');

Route::get('/country', function () {
    return view('configuracion.countries.index');
})->middleware('can:co_countrys')->name('ubicacionCountry');

Route::get('/areas', function () {
    return view('configuracion.areas.index');
})->middleware('can:co_areas')->name('ubicacionAreas');

Route::get('/sedes', function () {
    return view('configuracion.sedes.index');
})->middleware('can:co_sedes')->name('sedes');

Route::get('/roles', function () {
    return view('configuracion.roles.index');
})->middleware('can:co_rols')->name('roles');
