<?php

use App\Http\Controllers\Admin\CountryController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/saluds', function () {
    return view('admin.salud.index');
})->middleware('can:ad_saluds')->name('saluds');

Route::get('/multis', function () {
    return view('admin.multi.index');
})->middleware('can:ad_multis')->name('multis');

Route::get('/profesores', function () {
    return view('admin.profesores.index');
})->middleware('can:ad_profesores')->name('profesores');


Route::resource('/countries', CountryController::class)->except('show');
