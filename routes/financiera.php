<?php

use Illuminate\Support\Facades\Route;

Route::get('/conceptopagos', function () {
    return view('financiera.conceptopagos.index');
})->middleware('can:fi_conceptopagos')->name('conceptopagos');
