<?php

use Illuminate\Support\Facades\Route;

Route::get('/imprecibo', function () {
    return view('impresiones.imprecibo');
})->name('imprecibo');

Route::get('/impperfil', function () {
    return view('impresiones.impperfil');
})->name('impperfil');
