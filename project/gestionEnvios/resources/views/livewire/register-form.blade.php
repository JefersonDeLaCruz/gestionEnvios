<div class="flex flex-col h-full">
    <div class="flex-1 px-8 pb-8 py-4">
        <!-- Header con Logo -->
        <div class="flex justify-center mb-6">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-8 w-8 text-white fill-current">
                <g>
                    <path
                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
                    </path>
                </g>
            </svg>
        </div>

        <h2 class="text-3xl font-bold text-white mb-8">Crea tu cuenta</h2>

        <form wire:submit.prevent="register" class="space-y-6">

            <!-- NOMBRE -->
            <div class="relative group">
                <input type="text" wire:model="name" id="reg_name"
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-[#1d9bf0] peer"
                    placeholder=" " maxlength="50" required />
                <label for="reg_nombre"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-[#1d9bf0] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                    Nombre
                </label>
                <!-- Contador de caracteres -->
                <div class="absolute top-2 right-2 text-gray-500 text-xs hidden group-focus-within:block">
                    {{ strlen($name) }} / 50
                </div>
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- APELLIDO -->
            <div class="relative group">
                <input type="text" wire:model="last_name" id="reg_last_name"
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-[#1d9bf0] peer"
                    placeholder=" " maxlength="50" required />
                <label for="reg_apellido"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-[#1d9bf0] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                    Apellido
                </label>
                {{-- Contador de caracteres --}}
                <div class="absolute top-2 right-2 text-gray-500 text-xs hidden group-focus-within:block">
                    {{ strlen($last_name) }} / 50
                </div>
                @error('last_name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- TELÉFONO -->
            <div class="relative group">
                <input type="tel" wire:model="phone" id="reg_phone"
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-[#1d9bf0] peer"
                    placeholder=" " maxlength="12" minlength="8" required />
                <label for="reg_telefono"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-[#1d9bf0] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                    Teléfono
                </label>
                @error('phone')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- EMAIL -->
            <div class="relative group">
                <input type="email" wire:model="email" id="reg_email"
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-[#1d9bf0] peer"
                    placeholder=" " required />
                <label for="reg_email"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-[#1d9bf0] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                    Correo electrónico
                </label>
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="relative group">
                {{-- CAMPO PARA INGRESAR LA CONTRASEÑA SIN VALIDACIONES (NO BORRAR) --}}
                {{-- <input type="password" wire:model="password" id="reg_password"
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-[#1d9bf0] peer"
                    placeholder=" " required /> --}}

                {{-- VALIDACION DE LA CONTRASEÑA --}}
                <div class="relative group" x-data="{ show: false }">

                    <input :type="show ? 'text' : 'password'" wire:model="password" id="reg_password"
                        class="block pl-2.5 pr-10 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-[#1d9bf0] peer"
                        placeholder=" " required minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo."/>
                        {{-- pattern -> traduccion al frontend de la validacion en el back --}}
                    <label for="reg_password"
                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-[#1d9bf0] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1 pointer-events-none">
                        Contraseña
                    </label>

                    <button type="button" @click="show = !show"
                        class="absolute top-1/2 -translate-y-1/2 right-3 text-gray-500 hover:text-[#1d9bf0] focus:outline-none transition-colors cursor-pointer z-20">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>

                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="w-full bg-white text-black rounded-full py-3 px-4 font-bold hover:bg-gray-200 transition mt-8 disabled:opacity-50 disabled:cursor-not-allowed">
                Registrarse
            </button>
        </form>
    </div>
</div>
