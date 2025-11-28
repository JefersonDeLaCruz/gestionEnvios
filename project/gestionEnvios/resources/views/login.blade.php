@extends('layout.base')

@section('title', 'Login | PACXPRESS')

@section('content')
    <style>
        /* Animación para que el gradiente del texto se mueva */
        @keyframes gradient-x {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient-x {
            background-size: 200% auto;
            animation: gradient-x 4s ease infinite;
        }

        /* Animación de entrada (Fade In + Slide Up) */
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-enter {
            animation: fade-in-up 0.8s ease-out forwards;
        }

        /* Retraso para que los elementos no carguen todos de golpe */
        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }
    </style>

    <!-- Login Modal -->
    <div x-data="{ loginOpen: false, registerOpen: false }" @open-register-modal.window="loginOpen = false; registerOpen = true"
        @open-login-modal.window="registerOpen = false; loginOpen = true">
        <div x-show="loginOpen" x-cloak style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="loginOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-[rgba(91,112,131,0.4)] transition-opacity" aria-hidden="true"
                    @click="loginOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="loginOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-black rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-[600px] sm:w-full min-h-[600px] relative">
                    <button @click="loginOpen = false"
                        class="absolute top-4 left-4 p-2 rounded-full hover:bg-gray-900 transition z-10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>

                    @livewire('login-form')
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div x-show="registerOpen" x-cloak style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="registerOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-[rgba(91,112,131,0.4)] transition-opacity" aria-hidden="true"
                    @click="registerOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="registerOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-black rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-[600px] sm:w-full min-h-[600px] relative">
                    <button @click="registerOpen = false"
                        class="absolute top-4 left-4 p-2 rounded-full hover:bg-gray-900 transition z-10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>

                    @livewire('register-form')
                </div>
            </div>
        </div>

        <div class="bg-black min-h-screen flex flex-col justify-center items-center lg:flex-row text-white p-4 lg:p-0 overflow-hidden">

            <div class="w-full lg:w-1/2 flex justify-center items-center h-full mb-10 lg:mb-0">
                <svg viewBox="0 0 24 24" aria-hidden="true"
                    class="h-16 w-16 lg:h-[350px] lg:w-[350px] fill-current text-white cursor-default">
                    <g>
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
                        </path>
                    </g>
                </svg>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center lg:items-start px-4 lg:pl-10 max-w-2xl text-center lg:text-left">

                <div class="opacity-0 animate-enter">
                    <h1 class="text-5xl lg:text-7xl font-extrabold mb-12 tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-400 to-[#1d9bf0] animate-gradient-x pb-2">
                        Gestiona, envía <br>y monitorea
                    </h1>
                </div>

                <div class="opacity-0 animate-enter delay-100">
                    <h2 class="text-3xl font-bold mb-8">Comienza a gestionar</h2>
                </div>

                <div class="w-full max-w-[300px] flex flex-col gap-3 opacity-0 animate-enter delay-200">


                    <div class="flex items-center w-full my-1">
                        <div class="h-px bg-gray-700 flex-1"></div>
                    </div>

                    <div class="w-full max-w-[300px] space-y-3">
                        <button @click="registerOpen = true"
                            class="w-full bg-[#1d9bf0] hover:bg-[#1a8cd8] text-white font-bold py-2.5 px-4 rounded-full transition duration-200">
                            Crear cuenta
                        </button>

                        <div class="pt-10">
                            <h3 class="font-bold text-center text-[17px] mb-4">¿Ya tienes una cuenta?</h3>
                            <button @click="loginOpen = true"
                                class="w-full border border-gray-600 text-[#1d9bf0] font-bold py-2.5 px-4 rounded-full hover:bg-[rgba(29,155,240,0.1)] transition duration-200">
                                Iniciar sesión
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
