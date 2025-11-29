<div class="flex flex-col h-full">
    <div class="flex-1 px-8 pb-8 py-4">
        <div class="flex justify-center mb-6">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-8 w-8 text-base-content fill-current">
                <g>
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                </g>
            </svg>
        </div>
        
        <h2 class="text-3xl font-bold text-base-content mb-8">Inicia sesión en X</h2>

        <div class="space-y-4">
            <button class="w-full btn btn-outline rounded-full py-2.5 px-4 font-bold transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M21.35 11.1h-9.17v2.73h6.51c-.33 3.81-3.5 5.44-6.5 5.44C8.36 19.27 5 16.25 5 12c0-4.1 3.2-7.27 7.2-7.27 3.09 0 4.9 1.97 4.9 1.97L19 4.72S16.56 2 12.1 2C6.42 2 2.03 6.8 2.03 12c0 5.05 4.13 10 10.22 10 5.35 0 9.25-3.67 9.25-9.09 0-1.15-.15-1.81-.15-1.81z"/>
                </svg>
                Iniciar sesión con Google
            </button>
            

            <div class="flex items-center my-4">
                <div class="flex-1 h-px bg-base-300"></div>
                <span class="px-2 text-base-content/60 text-sm">o</span>
                <div class="flex-1 h-px bg-base-300"></div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="relative group">
                    <input type="email" name="email" id="email" 
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer" 
                        placeholder=" " required value="{{ old('email') }}" />
                    <label for="email" class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Teléfono, correo electrónico o nombre de usuario</label>
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- FUNCIONALIDAD PARA MOSTRAR LA CONTRASEÑA --}}
                <div class="relative group" x-data="{ showPassword: false }">
                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" 
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer pr-10" 
                        placeholder=" " required />
                    
                    <label for="password" class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Contraseña</label>
                    
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/60 hover:text-base-content focus:outline-none z-20">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>

                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full btn btn-outline rounded-full py-2.5 px-4 font-bold transition mt-4">
                    Siguiente
                </button>
            </form>

            <button class="w-full btn btn-ghost border border-base-300 rounded-full py-2.5 px-4 font-bold transition mt-4">
                ¿Olvidaste tu contraseña?
            </button>
        </div>
        
        <p class="text-base-content/60 text-sm mt-8">
            ¿No tienes una cuenta? <a href="#" @click.prevent="$dispatch('open-register-modal')" class="text-secondary hover:underline">Regístrate</a>
        </p>
    </div>
</div>