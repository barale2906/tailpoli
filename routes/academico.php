<?php

use Illuminate\Support\Facades\Route;

Route::get('/cursos', function () {
    return view('academico.cursos.index');
})->name('cursos');

Route::get('/horarios', function () {
    return view('academico.horario.index');
})->name('cursoHorarios');

Route::get('/modulos', function () {
    return view('academico.modulo.index');
})->name('modulos');
