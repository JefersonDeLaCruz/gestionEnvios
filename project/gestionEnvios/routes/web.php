<?php

use App\Http\Controllers\ClienteController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

Route::get('/test', function () {
    return view('test');
});

Route::get('/', [ClienteController::class, 'index'])->name('home');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/register', 'register')->name('register');

});

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
