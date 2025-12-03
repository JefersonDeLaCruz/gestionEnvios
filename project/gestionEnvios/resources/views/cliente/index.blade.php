@extends('layout.base')

@section('title', 'Home')
@section('navbar')
    @include('layout.navbar')
@endsection
@section('content')
    <div class="min-h-[calc(100vh-70px)] px-4 sm:px-6 lg:px-8 py-8">
        <div class="w-full max-w-7xl mx-auto">
            <!-- Hero Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
                    Rastrear Paquete
                </h1>
                <p class="text-sm sm:text-base lg:text-lg opacity-80 max-w-2xl mx-auto">
                    Ingresa tu código de seguimiento para ver el estado en tiempo real de tu envío,
                    ruta de entrega e historial completo.
                </p>
            </div>

            <!-- Livewire Component -->
            @livewire('cliente.estado-envio')
        </div>
    </div>
@endsection
@section('footer')
@include('layout.footer')