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

Route::get('/grupos', function () {
    return view('academico.grupo.index');
})->middleware('can:ac_grupos')->name('grupos');

Route::get('/matriculas', function () {
    return view('academico.matriculas.index');
})->middleware('can:ac_matriculas')->name('matriculas');

Route::get('/estudiantes', function () {
    return view('academico.estudiantes.index');
})->middleware('can:ac_estudiantes')->name('estudiantes');

Route::get('/notas', function () {
    return view('academico.notas.index');
})->middleware('can:ac_notas')->name('notas');

Route::get('/ciclos', function () {
    return view('academico.ciclos.index');
})->middleware('can:ac_ciclos')->name('ciclos');

Route::get('/gestion', function () {
    return view('academico.gestion.index');
})->middleware('can:ac_gestion')->name('gestion');

Route::get('/especial', function () {
    return view('academico.especial.index');
})->middleware('can:ac_gestion')->name('especial');

Route::get('/gradua', function () {
    return view('academico.graduacion.index');
})->middleware('can:ac_graduaciones')->name('gradua');
