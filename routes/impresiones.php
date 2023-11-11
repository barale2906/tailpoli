<?php

use Illuminate\Support\Facades\Route;

Route::get('/imprecibo', function () {
    return view('impresiones.imprecibo');
})->name('imprecibo');

Route::get('/impperfil', function () {
    return view('impresiones.impperfil');
})->name('impperfil');

Route::get('/impcierre', function () {
    return view('impresiones.impcierre');
})->name('impcierre');

Route::get('/impcontrato', function () {
    return view('impresiones.impcontrato');
})->name('impcontrato');

Route::get('/imppagare', function () {
    return view('impresiones.imppagare');
})->name('imppagare');
