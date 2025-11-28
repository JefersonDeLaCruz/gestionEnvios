<?php

use App\Http\Controllers\ClienteController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

Route::get('/test', function () {
    return view('test');
});

Route::get('/', [ClienteController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
