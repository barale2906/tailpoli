<?php

use App\Http\Controllers\Admin\CountryController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('/countries', CountryController::class)->except('show');
