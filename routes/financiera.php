<?php

use Illuminate\Support\Facades\Route;

Route::get('/recibopagos', function () {
    return view('financiera.recibospago.index');
})->middleware('can:fi_recibopagos')->name('recibopagos');

Route::get('/conceptopagos', function () {
    return view('financiera.conceptopagos.index');
})->middleware('can:fi_conceptopagos')->name('conceptopagos');

Route::get('/configpagos', function () {
    return view('financiera.configpagos.index');
})->middleware('can:fi_configuracionpagos')->name('configpagos');

Route::get('/cierrecaja', function () {
    return view('financiera.cierrecaja.index');
})->middleware('can:fi_cierrecaja')->name('cierrecaja');
