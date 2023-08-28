<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    /* session()->flash('Swal', [

            'icon'=> 'error',
            'title'=> 'Oops...',
            'text'=> 'Something went wrong!',
            'footer'=> '<a href="">Why do I have this issue?</a>'

    ]); */

    return view('admin.dashboard');
})->name('dashboard');
