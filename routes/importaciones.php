<?php

use Illuminate\Support\Facades\Route;

Route::get('/impornotas', function () {
    return view('configuracion.importaciones.imporNotas');
})->middleware('can:co_impornotas')->name('impornotas');
