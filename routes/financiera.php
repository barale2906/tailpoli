<?php

use Illuminate\Support\Facades\Route;

Route::get('/conceptopagos', function () {
    return view('financiera.conceptopagos.index');
})->middleware('can:conceptopagos')->name('conceptopagos');
