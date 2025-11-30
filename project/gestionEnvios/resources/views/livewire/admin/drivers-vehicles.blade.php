<div class="p-6">
    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Repartidores y Vehículos</h1>
        <p class="text-base-content/70 mt-1">Administra los repartidores y vehículos de la flota</p>
    </div>

    {{-- Drivers Section --}}
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Repartidores</h2>
                <button wire:click="openDriverModal" class="btn btn-primary gap-2 btn-sm md:btn-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuevo Repartidor
                </button>
            </div>

            @if($drivers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Vehículo Asignado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $driver)
                                @php
                                    $assignedVehicle = $driver->vehiculos->first();
                                @endphp
                                <tr>
                                    <td>
                                        <div class="font-medium">{{ $driver->nombre }} {{ $driver->apellido }}</div>
                                        <div class="text-sm text-base-content/60">{{ $driver->direccion }}</div>
                                    </td>
                                    <td>{{ $driver->email }}</td>
                                    <td>{{ $driver->telefono }}</td>
                                    <td>
                                        @if($assignedVehicle)
                                            <div class="flex items-center gap-2">
                                                <span class="badge badge-secondary">{{ $assignedVehicle->numero_placas }}</span>
                                                <span class="text-sm">{{ $assignedVehicle->marca }}
                                                    {{ $assignedVehicle->modelo }}</span>
                                            </div>
                                        @else
                                            <span class="text-base-content/50">Sin vehículo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap gap-2 items-center">
                                            <button wire:click="openDriverModal({{ $driver->id }})"
                                                class="btn btn-ghost btn-xs">
                                                Editar
                                            </button>
                                            <button wire:click="openAssignmentModal({{ $driver->id }})"
                                                class="btn btn-primary btn-xs h-auto py-2">
                                                <span class="block sm:inline">{{ $assignedVehicle ? 'Cambiar' : 'Asignar' }}</span>
                                                <span class="block sm:inline">Vehículo</span>
                                            </button>
                                            @if($assignedVehicle)
                                                <button wire:click="unassignVehicle({{ $driver->id }})"
                                                    class="btn btn-warning btn-xs">
                                                    Desasignar
                                                </button>
                                            @endif
                                            <button wire:click="deleteDriver({{ $driver->id }})"
                                                wire:confirm="¿Estás seguro de eliminar este repartidor?"
                                                class="btn btn-error btn-xs">
                                                Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-16 h-16 mx-auto text-base-content/30 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-base-content/70">No hay repartidores registrados</h3>
                    <p class="text-base-content/50 mt-2">Agrega tu primer repartidor para comenzar</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Vehicles Section --}}
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Vehículos</h2>
                <button wire:click="openVehicleModal" class="btn btn-primary gap-2 btn-sm md:btn-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuevo Vehículo
                </button>
            </div>

            @if($vehicles->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Placas</th>
                                <th>Marca/Modelo</th>
                                <th>Tipo</th>
                                <th>Capacidad</th>
                                <th>Estado</th>
                                <th>Asignado a</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $vehicle)
                                @php
                                    $assignedDriver = $vehicle->motoristas->first();
                                @endphp
                                <tr>
                                    <td class="font-mono font-bold">{{ $vehicle->numero_placas }}</td>
                                    <td>{{ $vehicle->marca }} {{ $vehicle->modelo }}</td>
                                    <td>{{ $vehicle->tipoVehiculo?->nombre ?? 'N/A' }}</td>
                                    <td>
                                        <div class="text-sm">
                                            <div>{{ $vehicle->capacidad_kg }} kg</div>
                                            <div class="text-base-content/60">{{ $vehicle->capacidad_m3 }} m³</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($vehicle->disponible)
                                            <span class="badge badge-success">Disponible</span>
                                        @else
                                            <span class="badge badge-error">No disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignedDriver)
                                            <div class="font-medium">{{ $assignedDriver->nombre }} {{ $assignedDriver->apellido }}
                                            </div>
                                        @else
                                            <span class="text-base-content/50">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <button wire:click="openVehicleModal({{ $vehicle->id }})"
                                                class="btn btn-ghost btn-xs">
                                                Editar
                                            </button>
                                            <button wire:click="deleteVehicle({{ $vehicle->id }})"
                                                wire:confirm="¿Estás seguro de eliminar este vehículo?"
                                                class="btn btn-error btn-xs">
                                                Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-16 h-16 mx-auto text-base-content/30 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    <h3 class="text-lg font-semibold text-base-content/70">No hay vehículos registrados</h3>
                    <p class="text-base-content/50 mt-2">Agrega tu primer vehículo para comenzar</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Driver Modal (Create/Edit) --}}
    @if($showDriverModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-2xl border border-base-300">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">{{ $editingDriverId ? 'Editar' : 'Nuevo' }} Repartidor</h2>
                <button wire:click="closeDriverModal" class="btn btn-sm btn-circle btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="saveDriver">
                <div class="grid grid-cols-2 gap-4">
                    {{-- Nombre --}}
                    <div class="relative">
                        <input type="text" wire:model="driver_nombre" id="driver_nombre" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('driver_nombre') border-error @else border-base-300 @enderror">
                        <label for="driver_nombre"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('driver_nombre') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Nombre
                        </label>
                        @error('driver_nombre')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Apellido --}}
                    <div class="relative">
                        <input type="text" wire:model="driver_apellido" id="driver_apellido" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('driver_apellido') border-error @else border-base-300 @enderror">
                        <label for="driver_apellido"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('driver_apellido') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Apellido
                        </label>
                        @error('driver_apellido')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="relative col-span-2">
                        <input type="email" wire:model="driver_email" id="driver_email" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('driver_email') border-error @else border-base-300 @enderror">
                        <label for="driver_email"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('driver_email') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Email
                        </label>
                        @error('driver_email')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div class="relative">
                        <input type="text" wire:model="driver_telefono" id="driver_telefono" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('driver_telefono') border-error @else border-base-300 @enderror">
                        <label for="driver_telefono"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('driver_telefono') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Teléfono
                        </label>
                        @error('driver_telefono')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Dirección --}}
                    <div class="relative">
                        <input type="text" wire:model="driver_direccion" id="driver_direccion" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('driver_direccion') border-error @else border-base-300 @enderror">
                        <label for="driver_direccion"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('driver_direccion') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Dirección
                        </label>
                        @error('driver_direccion')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password (only for create) --}}
                    @if(!$editingDriverId)
                    <div class="relative col-span-2">
                        <input type="password" wire:model="driver_password" id="driver_password" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('driver_password') border-error @else border-base-300 @enderror">
                        <label for="driver_password"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('driver_password') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Contraseña
                        </label>
                        @error('driver_password')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                </div>

                <div class="modal-action">
                    <button type="button" wire:click="closeDriverModal" class="btn btn-ghost rounded-full font-bold">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-full font-bold">
                        {{ $editingDriverId ? 'Actualizar' : 'Crear' }} Repartidor
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Vehicle Modal (Create/Edit) --}}
    @if($showVehicleModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-2xl border border-base-300">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">{{ $editingVehicleId ? 'Editar' : 'Nuevo' }} Vehículo</h2>
                <button wire:click="closeVehicleModal" class="btn btn-sm btn-circle btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="saveVehicle">
                <div class="grid grid-cols-2 gap-4">
                    {{-- Tipo de Vehículo --}}
                    <div class="relative col-span-2">
                        <select wire:model="vehicle_tipo_vehiculo_id" id="vehicle_tipo_vehiculo_id"
                            class="peer w-full px-4 pt-6 pb-2 bg-transparent border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition-all
                                   @error('vehicle_tipo_vehiculo_id') border-error @else border-base-300 @enderror">
                            <option value="">Selecciona un tipo</option>
                            @foreach($tiposVehiculo as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                        <label for="vehicle_tipo_vehiculo_id"
                            class="absolute left-4 top-2 text-xs text-base-content/60 bg-base-100 px-1">
                            Tipo de Vehículo
                        </label>
                        @error('vehicle_tipo_vehiculo_id')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Número de Placas --}}
                    <div class="relative">
                        <input type="text" wire:model="vehicle_numero_placas" id="vehicle_numero_placas" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('vehicle_numero_placas') border-error @else border-base-300 @enderror">
                        <label for="vehicle_numero_placas"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('vehicle_numero_placas') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Número de Placas
                        </label>
                        @error('vehicle_numero_placas')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Marca --}}
                    <div class="relative">
                        <input type="text" wire:model="vehicle_marca" id="vehicle_marca" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('vehicle_marca') border-error @else border-base-300 @enderror">
                        <label for="vehicle_marca"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('vehicle_marca') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Marca
                        </label>
                        @error('vehicle_marca')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Modelo --}}
                    <div class="relative col-span-2">
                        <input type="text" wire:model="vehicle_modelo" id="vehicle_modelo" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('vehicle_modelo') border-error @else border-base-300 @enderror">
                        <label for="vehicle_modelo"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('vehicle_modelo') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Modelo
                        </label>
                        @error('vehicle_modelo')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Capacidad Kg --}}
                    <div class="relative">
                        <input type="number" step="0.01" wire:model="vehicle_capacidad_kg" id="vehicle_capacidad_kg" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('vehicle_capacidad_kg') border-error @else border-base-300 @enderror">
                        <label for="vehicle_capacidad_kg"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('vehicle_capacidad_kg') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Capacidad (kg)
                        </label>
                        @error('vehicle_capacidad_kg')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Capacidad M³ --}}
                    <div class="relative">
                        <input type="number" step="0.01" wire:model="vehicle_capacidad_m3" id="vehicle_capacidad_m3" placeholder=" "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                   @error('vehicle_capacidad_m3') border-error @else border-base-300 @enderror">
                        <label for="vehicle_capacidad_m3"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                   @error('vehicle_capacidad_m3') !-translate-y-4 !scale-75 !top-2 @enderror">
                            Capacidad (m³)
                        </label>
                        @error('vehicle_capacidad_m3')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Disponible Toggle --}}
                    <div class="col-span-2 flex items-center gap-3 p-4 border border-base-300 rounded-lg">
                        <input type="checkbox" wire:model="vehicle_disponible" id="vehicle_disponible" class="toggle toggle-primary" />
                        <label for="vehicle_disponible" class="font-medium cursor-pointer">Vehículo Disponible</label>
                    </div>
                </div>

                <div class="modal-action">
                    <button type="button" wire:click="closeVehicleModal" class="btn btn-ghost rounded-full font-bold">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-full font-bold">
                        {{ $editingVehicleId ? 'Actualizar' : 'Crear' }} Vehículo
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Assignment Modal --}}
    @if($showAssignmentModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-2xl border border-base-300">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Asignar Vehículo</h2>
                <button wire:click="closeAssignmentModal" class="btn btn-sm btn-circle btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="assignVehicle">
                @if($availableVehicles->count() > 0)
                <div class="space-y-4">
                    <p class="text-base-content/70 mb-4">Selecciona un vehículo disponible:</p>
                    
                    @foreach($availableVehicles as $vehicle)
                    <label class="flex items-center gap-4 p-4 border border-base-300 rounded-lg cursor-pointer hover:bg-base-200 transition {{ $selectedVehicleId == $vehicle->id ? 'bg-secondary/10 border-secondary' : '' }}">
                        <input type="radio" wire:model.live="selectedVehicleId" value="{{ $vehicle->id }}" class="radio radio-secondary" />
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <div class="avatar placeholder">
                                    <div class="bg-secondary text-secondary-content rounded-full w-12">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold text-lg">{{ $vehicle->marca }} {{ $vehicle->modelo }}</div>
                                    <div class="text-sm text-base-content/60">{{ $vehicle->tipoVehiculo?->nombre ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center gap-4 text-sm">
                                <span class="badge badge-secondary">{{ $vehicle->numero_placas }}</span>
                                <span class="text-base-content/60">Capacidad: {{ $vehicle->capacidad_kg }} kg • {{ $vehicle->capacidad_m3 }} m³</span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <div class="modal-action">
                    <button type="button" wire:click="closeAssignmentModal" class="btn btn-ghost rounded-full font-bold">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-full font-bold gap-2" @disabled(!$selectedVehicleId)>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        Asignar Vehículo
                    </button>
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-base-content/30 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    <h3 class="text-lg font-semibold text-base-content/70">No hay vehículos disponibles</h3>
                    <p class="text-base-content/50 mt-2">Todos los vehículos están asignados o no disponibles</p>
                    <button type="button" wire:click="closeAssignmentModal" class="btn btn-ghost rounded-full font-bold mt-4">
                        Cerrar
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
    @endif
</div>
