<?php

use App\Http\Controllers\Admin\CountryController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/saluds', function () {
    return view('admin.salud.index');
})->name('saluds');



Route::resource('/countries', CountryController::class)->except('show');
