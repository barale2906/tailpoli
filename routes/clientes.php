<?php

use Illuminate\Support\Facades\Route;

Route::get('/crm', function () {
    return view('cliente.crm.index');
})->middleware('can:cl_crm')->name('crm');

Route::get('/pqrs', function () {
    return view('cliente.pqrs.index');
})->middleware('can:cl_pqrs')->name('pqrs');
