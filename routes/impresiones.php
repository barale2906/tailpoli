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

Route::get('/impcartapagare', function () {
    return view('impresiones.impcartapagare');
})->name('impcartapagare');

Route::get('/impcertiestudio', function () {
    return view('impresiones.impcertiestudio');
})->name('impcertiestudio');

Route::get('/impactapago', function () {
    return view('impresiones.impactapago');
})->name('impactapago');

Route::get('/impcomprocredito', function () {
    return view('impresiones.impcomprocredito');
})->name('impcomprocredito');

Route::get('/impcartaentregadoc', function () {
    return view('impresiones.impcartaentregadoc');
})->name('impcartaentregadoc');

Route::get('/impestadocuenta', function () {
    return view('impresiones.impestadocuenta');
})->name('impestadocuenta');

Route::get('/impcartacobro', function () {
    return view('impresiones.impcartacobro');
})->name('impcartacobro');

Route::get('/impgastocertifinal', function () {
    return view('impresiones.impgastocertifinal');
})->name('impgastocertifinal');

Route::get('/impformuPractica', function () {
    return view('impresiones.impformuPractica');
})->name('impformuPractica');

Route::get('/impRemision', function () {
    return view('impresiones.impRemision');
})->name('impRemision');

Route::get('/impTraslado', function () {
    return view('impresiones.impTraslado');
})->name('impTraslado');
