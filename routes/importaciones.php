<?php

use Illuminate\Support\Facades\Route;

Route::get('/impornotas', function () {
    return view('configuracion.importaciones.imporNotas');
})->middleware('can:co_impornotas')->name('impornotas');

Route::get('/imporbds', function () {
    return view('configuracion.importaciones.imporDb');
})->middleware('can:co_imporDB')->name('imporbds');
