<?php

namespace App\Providers;
use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // registra manualmente el componente (usa el namespace actual)
        Livewire::component('cliente.estado-envio', \App\Livewire\Cliente\EstadoEnvio::class);


    }
}
