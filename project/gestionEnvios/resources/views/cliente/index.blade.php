@extends('layout.base')

@section('title', 'Home')
@section('navbar')
    @include('layout.navbar')
@endsection
@section('content')
    <div class="hero min-h-[calc(100vh-70px)] px-4 sm:px-6 lg:px-8">
        <div class="hero-content w-full max-w-7xl p-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 xl:gap-16 w-full items-center">
                <!-- Tracking Form Section -->
                <div class="w-full max-w-md mx-auto lg:mx-0 text-center lg:text-left px-4 sm:px-0">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 sm:mb-6 lg:mb-8">
                        Rastrear Paquete
                    </h1>
                    <p class="text-sm sm:text-base lg:text-lg py-4 sm:py-6 opacity-80">
                        Ingresa tu código de seguimiento para ver el estado de tu envío.
                    </p>

                    {{-- Form que emite evento a Livewire --}}
                    <form
                        onsubmit="event.preventDefault(); Livewire.dispatch('buscarCodigo', { codigo: document.getElementById('trackingCodeLeft').value })">
                        @csrf
                        <div class="form-control w-full">
                            <input id="trackingCodeLeft" type="text" placeholder="Ej: PKG-12345678"
                                class="input input-bordered w-full ..." />
                        </div>

                        <button type="submit" class="btn btn-secondary ... mt-3">Rastrear</button>
                    </form>


                </div>

                <!-- Package Status Section (tu component blade) -->
                <x-package-status>
                    <div class="text-center lg:text-left">
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold mb-4">
                            Estado del Paquete
                        </h2>
                        <p class="text-sm sm:text-base opacity-70">
                            Aqui irá lo del estado del paquete, el cual será un componente Livewire
                        </p>
                    </div>

                    <div class="mt-4">
                        @livewire('cliente.estado-envio')
                    </div>
                </x-package-status>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('layout.footer')
@endsection