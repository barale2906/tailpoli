<?php

use Illuminate\Support\Facades\Route;

Route::get('/configuracion', function () {
    return view('humana.configuracion.index');
})->middleware('can:hu_configuracion')->name('configuracion');
