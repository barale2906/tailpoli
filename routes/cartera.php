<?php

use Illuminate\Support\Facades\Route;

Route::get('/carteras', function () {
    return view('cartera.carteras.index');
})->middleware('can:ca_carteras')->name('carteras');
