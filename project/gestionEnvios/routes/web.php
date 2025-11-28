<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/home', [ClienteController::class, 'index'])->name('cliente.index');
