<div class="flex flex-col h-full">
    <div class="flex-1 px-8 pb-8 py-4">
        <div class="flex justify-center mb-6">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-8 w-8 text-white fill-current">
                <g>
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                </g>
            </svg>
        </div>
        
        <h2 class="text-3xl font-bold text-white mb-8">Crea tu cuenta</h2>

        <form wire:submit.prevent="register" class="space-y-6">
            <div class="relative group">
                <input type="text" wire:model="name" id="reg_name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-blue-500 peer" placeholder=" " maxlength="50" />
                <label for="reg_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nombre</label>
                <div class="absolute top-2 right-2 text-gray-500 text-xs hidden group-focus-within:block">{{ strlen($name) }} / 50</div>
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="relative group">
                <input type="email" wire:model="email" id="reg_email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-blue-500 peer" placeholder=" " />
                <label for="reg_email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Correo electrónico</label>
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
             <div class="relative group">
                <input type="password" wire:model="password" id="reg_password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-md border border-gray-600 appearance-none focus:outline-none focus:ring-0 focus:border-blue-500 peer" placeholder=" " />
                <label for="reg_password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-black px-2 peer-focus:px-2 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Contraseña</label>
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <h3 class="font-bold text-white text-sm mb-1">Fecha de nacimiento</h3>
                <p class="text-gray-500 text-xs mb-3">Esta información no será pública. Confirma tu propia edad, incluso si esta cuenta es para una empresa, una mascota u otra cosa.</p>
                
                <div class="flex gap-3">
                    <div class="flex-grow-[2]">
                        <select wire:model="month" class="w-full bg-black text-white border border-gray-600 rounded-md p-3 focus:border-blue-500 focus:outline-none appearance-none">
                            <option value="">Mes</option>
                            @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $m)
                                <option value="{{ $index + 1 }}">{{ $m }}</option>
                            @endforeach
                        </select>
                         @error('month') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-grow">
                        <select wire:model="day" class="w-full bg-black text-white border border-gray-600 rounded-md p-3 focus:border-blue-500 focus:outline-none appearance-none">
                            <option value="">Día</option>
                            @for($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                         @error('day') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-grow">
                        <select wire:model="year" class="w-full bg-black text-white border border-gray-600 rounded-md p-3 focus:border-blue-500 focus:outline-none appearance-none">
                            <option value="">Año</option>
                            @for($i = date('Y'); $i >= 1900; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                         @error('year') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-white text-black rounded-full py-3 px-4 font-bold hover:bg-gray-200 transition mt-8 disabled:opacity-50 disabled:cursor-not-allowed">
                Siguiente
            </button>
        </form>
    </div>
</div>
