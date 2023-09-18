<?php

use Illuminate\Support\Facades\Route;

Route::get('/cursos', function () {
    return view('academico.cursos.index');
})->middleware('can:ac_cursos')->name('cursos');

Route::get('/horarios', function () {
    return view('academico.horario.index');
})->middleware('can:ac_horarios')->name('cursoHorarios');

Route::get('/modulos', function () {
    return view('academico.modulo.index');
})->middleware('can:ac_modulos')->name('modulos');
