<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Livewire\LoginForm;

// =======================
// Rutas públicas
// =======================

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

Route::get('/formulario', LoginForm::class);

// =======================
// Rutas ADMIN
// =======================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
        Route::get('/packages', \App\Livewire\Admin\Packages::class)->name('admin.packages');
        Route::get('/drivers-vehicles', \App\Livewire\Admin\DriversVehicles::class)->name('admin.drivers-vehicles');
        Route::get('/all-shipments', \App\Livewire\Admin\AllShipments::class)->name('admin.all-shipments');
        Route::get('/users', \App\Livewire\Admin\Users::class)->name('admin.users');
        Route::get('/fleet', \App\Livewire\Admin\Fleet::class)->name('admin.fleet');
        Route::get('/reports', \App\Livewire\Admin\Reports::class)->name('admin.reports');
        Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('admin.settings');
    });

// =======================
// Rutas REPARTIDOR
// =======================

// Si el rol se llama "repartidor" en Spatie:
Route::middleware(['auth', 'role:repartidor'])
    ->prefix('repartidor')
    ->group(function () {
        Route::get('/dashboard', \App\Livewire\Repartidor\Dashboard::class)->name('repartidor.dashboard');
        Route::get('/route', \App\Livewire\Repartidor\Route::class)->name('repartidor.route');
        Route::get('/packages', \App\Livewire\Repartidor\Packages::class)->name('repartidor.packages');
        Route::get('/history', \App\Livewire\Repartidor\History::class)->name('repartidor.history');
        Route::get('/profile', \App\Livewire\Repartidor\Profile::class)->name('repartidor.profile');
    });

// si quieres que admin TAMBIÉN pueda ver rutas de repartidor:
// Route::middleware(['auth', 'role:repartidor|admin']) ...

// =======================
// Redirecciones
// =======================

Route::get('/admin', fn() => redirect()->route('admin.dashboard'))->name('admin');
Route::get('/repartidor', fn() => redirect()->route('repartidor.dashboard'))->name('repartidor');


