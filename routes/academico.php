<?php

use Illuminate\Support\Facades\Route;

Route::get('/cursos', function () {
    return view('academico.cursos.index');
})->name('cursos');
