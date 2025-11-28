<div class="flex flex-col h-full">
    <div class="flex-1 px-8 pb-8 py-4">
        <div class="flex justify-center mb-6">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-8 w-8 text-white fill-current">
                <g>
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                </g>
            </svg>
        </div>
        
        <h2 class="text-3xl font-bold text-white mb-8">Inicia sesión en X</h2>

        <div class="space-y-4">
            <button class="w-full bg-white text-black rounded-full py-2.5 px-4 font-bold hover:bg-gray-200 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M21.35 11.1h-9.17v2.73h6.51c-.33 3.81-3.5 5.44-6.5 5.44C8.36 19.27 5 16.25 5 12c0-4.1 3.2-7.27 7.2-7.27 3.09 0 4.9 1.97 4.9 1.97L19 4.72S16.56 2 12.1 2C6.42 2 2.03 6.8 2.03 12c0 5.05 4.13 10 10.22 10 5.35 0 9.25-3.67 9.25-9.09 0-1.15-.15-1.81-.15-1.81z"/>
                </svg>
                Iniciar sesión con Google
            </button>
            

            <div class="flex items-center my-4">
                <div class="flex-1 h-px bg-gray-700"></div>
                <span class="px-2 text-gray-400 text-sm">o</span>
                <div class="flex-1 h-px bg-gray-700"></div>
            </div>

            <form wire:submit="login" class="space-y-4">
                <div class="relative group">
                    <input type="email" wire:model="email" id="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-blue-500 peer" placeholder=" " />
                    <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Teléfono, correo electrónico o nombre de usuario</label>
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="relative group">
                    <input type="password" wire:model="password" id="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-blue-500 peer" placeholder=" " />
                    <label for="password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Contraseña</label>
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-white text-black rounded-full py-2.5 px-4 font-bold hover:bg-gray-200 transition mt-4">
                    Siguiente
                </button>
            </form>

            <button class="w-full border border-gray-600 text-white rounded-full py-2.5 px-4 font-bold hover:bg-gray-900 transition mt-4">
                ¿Olvidaste tu contraseña?
            </button>
        </div>
        
        <p class="text-gray-500 text-sm mt-8">
            ¿No tienes una cuenta? <a href="#" @click="$dispatch('open-register-modal')" class="text-blue-500 hover:underline">Regístrate</a>
        </p>
    </div>
</div>
