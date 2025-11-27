@extends('layout.base')

@section('title', 'Bienvenido / Logística')

@section('content')
<style>
    /* Animación para que el gradiente del texto se mueva */
    @keyframes gradient-x {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    .animate-gradient-x {
        background-size: 200% auto;
        animation: gradient-x 4s ease infinite;
    }

    /* Animación de entrada (Fade In + Slide Up) */
    @keyframes fade-in-up {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-enter {
        animation: fade-in-up 0.8s ease-out forwards;
    }
    /* Retraso para que los elementos no carguen todos de golpe */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
</style>

<div class="bg-black min-h-screen flex flex-col justify-center items-center lg:flex-row text-white p-4 lg:p-0 overflow-hidden">
    
    <div class="w-full lg:w-1/2 flex justify-center items-center h-full mb-10 lg:mb-0">
        <svg viewBox="0 0 24 24" aria-hidden="true" class="h-16 w-16 lg:h-[350px] lg:w-[350px] fill-current text-white cursor-default">
            <g>
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
            </g>
        </svg>
    </div>

    <div class="w-full lg:w-1/2 flex flex-col justify-center px-4 lg:pl-10 max-w-2xl">
        
        <div class="opacity-0 animate-enter">
            <h1 class="text-5xl lg:text-7xl font-extrabold mb-12 tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-400 to-[#1d9bf0] animate-gradient-x pb-2">
                Gestiona, envía <br>y monitorea
            </h1>
        </div>

        <div class="opacity-0 animate-enter delay-100">
            <h2 class="text-3xl font-bold mb-8">Comienza a gestionar</h2>
        </div>

        <div class="w-full max-w-[300px] flex flex-col gap-3 opacity-0 animate-enter delay-200">
            
            <button class="btn bg-white text-black hover:bg-gray-200 border-none rounded-full capitalize text-base font-normal flex items-center gap-2 transition-transform active:scale-95">
                <svg viewBox="0 0 24 24" class="h-5 w-5">
                    <g>
                        <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                    </g>
                </svg>
                Registrarse con Google
            </button>

            <div class="flex items-center w-full my-1">
                <div class="h-px bg-gray-700 flex-1"></div>
                <span class="px-3 text-sm text-gray-200">o</span>
                <div class="h-px bg-gray-700 flex-1"></div>
            </div>

            <button class="btn bg-[#1d9bf0] hover:bg-[#1a8cd8] text-white border-none rounded-full capitalize text-base font-bold transition-transform hover:shadow-[0_0_15px_rgba(29,155,240,0.5)] active:scale-95">
                Crear cuenta
            </button>

            <div class="flex items-center w-full mt-5">
                <div class="h-px bg-gray-700 flex-1"></div>
                <div class="h-px bg-gray-700 flex-1"></div>
            </div>

            <div class="mt-1">
                <h3 class="text-xl text-center font-bold mb-4">¿Ya tienes una cuenta?</h3>
                
                <button class="btn btn-outline text-[#1d9bf0] border-gray-600 hover:bg-[#1d9bf0]/10 hover:border-[#1d9bf0] hover:text-[#1d9bf0] rounded-full w-full capitalize text-base font-bold mb-4 transition-all">
                    Iniciar sesión
                </button>
            </div>

        </div>
    </div>
</div>
@endsection