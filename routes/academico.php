<?php

use Illuminate\Support\Facades\Route;

Route::get('/cursos', function () {
    return view('academico.cursos.index');
})->middleware('can:cursos')->name('cursos');

Route::get('/horarios', function () {
    return view('academico.horario.index');
})->middleware('can:horarios')->name('cursoHorarios');

Route::get('/modulos', function () {
    return view('academico.modulo.index');
})->middleware('can:modulos')->name('modulos');
