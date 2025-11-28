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
                <input type="password" wire:model="password" id="reg_password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-[#1d9bf0] peer" placeholder=" "
                    required minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                    title="Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo." />
                <label for="reg_password"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-[#1d9bf0] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                    Contraseña
                </label>
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-white text-black rounded-full py-3 px-4 font-bold hover:bg-gray-200 transition mt-8 disabled:opacity-50 disabled:cursor-not-allowed">
                Registrarse
            </button>
        </form>
    </div>
</div>
