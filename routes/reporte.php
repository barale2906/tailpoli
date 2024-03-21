<?php

use App\Http\Controllers\Admin\CountryController;
use Illuminate\Support\Facades\Route;


Route::get('/academicos', function () {
    return view('reportes.academicos.index');
})->middleware('can:re_academicos')->name('academicos');

Route::get('/financieros', function () {
    return view('reportes.financieros.index');
})->middleware('can:re_financieros')->name('financieros');
