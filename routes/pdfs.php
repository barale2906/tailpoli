<?php

use Illuminate\Support\Facades\Route;

Route::get('/matricular', function () {
    return view('pdfs.matricular');
})->name('matricular');
