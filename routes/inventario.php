<?php

use Illuminate\Support\Facades\Route;

Route::get('/productos', function () {
    return view('inventario.productos.index');
})->middleware('can:in_productos')->name('productos');

Route::get('/almacens', function () {
    return view('inventario.almacens.index');
})->middleware('can:in_almacens')->name('almacens');

Route::get('/inventarios', function () {
    return view('inventario.inventarios.index');
})->middleware('can:in_inventarios')->name('inventarios');

Route::get('/pagoConfig', function () {
    return view('inventario.pagoconfig.index');
})->middleware('can:in_pagoconfig')->name('pagoConfig');
