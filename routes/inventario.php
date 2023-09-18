<?php

use Illuminate\Support\Facades\Route;

Route::get('/productos', function () {
    return view('inventario.productos.index');
})->middleware('can:productos')->name('productos');

Route::get('/almacens', function () {
    return view('inventario.almacens.index');
})->middleware('can:almacens')->name('almacens');

Route::get('/inventarios', function () {
    return view('inventario.inventarios.index');
})->middleware('can:inventarios')->name('inventarios');
