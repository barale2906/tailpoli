<?php

use Illuminate\Support\Facades\Route;

Route::get('/productos', function () {
    return view('inventario.productos.index');
})->name('productos');

Route::get('/almacens', function () {
    return view('inventario.almacens.index');
})->name('almacens');
