<div class="p-6">
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            .leaflet-map {
                height: 300px;
                width: 100%;
                border-radius: 0.5rem;
                z-index: 0;
            }
        </style>
    @endpush
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Gestión de Paquetes</h1>
            <p class="text-base-content/70 mt-1">Administra todos los paquetes y envíos</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary gap-2 btn-sm md:btn-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nuevo Envío
        </button>
    </div>

    <!-- Filters -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Buscar</span>
                    </label>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Número de seguimiento, cliente..." class="input input-bordered" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Estado</span>
                    </label>
                    <select wire:model.live="status" class="select select-bordered">
                        <option value="">Todos</option>
                        @foreach($statuses as $estado)
                            <option value="{{ $estado->nombre }}">{{ $estado->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Fecha</span>
                    </label>
                    <input type="date" wire:model.live="date" class="input input-bordered" />
                </div>
            </div>
        </div>
    </div>

    <!-- Packages Table -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title mb-4">Paquetes Pendientes de Asignación</h2>

            @if($pendingShipments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Emisor</th>
                                <th>Receptor</th>
                                <th>Descripción</th>
                                <th>Peso</th>
                                <th>Volumen</th>
                                <th>Costo</th>
                                <th>Fecha Estimada</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingShipments as $envio)
                                @php
                                    $emisor = $envio->paquete->envioClientes->where('tipo_cliente', 'emisor')->first()?->cliente;
                                    $receptor = $envio->paquete->envioClientes->where('tipo_cliente', 'receptor')->first()?->cliente;
                                @endphp

                                <tr>
                                    <td class="font-mono font-bold">{{ $envio->paquete->codigo }}</td>
                                    <td>
                                        <div class="font-medium">{{ $emisor?->nombre }} {{ $emisor?->apellido }}</div>
                                        <div class="text-sm text-base-content/60">{{ $emisor?->telefono }}</div>
                                    </td>
                                    <td>
                                        <div class="font-medium">{{ $receptor?->nombre }} {{ $receptor?->apellido }}</div>
                                        <div class="text-sm text-base-content/60">{{ $receptor?->direccion }}</div>
                                    </td>
                                    <td>
                                        <div class="max-w-xs truncate" title="{{ $envio->paquete->descripcion }}">
                                            {{ $envio->paquete->descripcion }}
                                        </div>
                                    </td>
                                    <td>{{ $envio->paquete->peso }} kg</td>
                                    <td>{{ $envio->paquete->dimensiones }} m³</td>
                                    <td>${{ number_format($envio->costo, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($envio->fecha_estimada)->format('d/m/Y') }}</td>
                                    <td>
                                        <button wire:click="openAssignModal({{ $envio->id }})"
                                            class="btn btn-primary btn-sm gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                            Asignar Repartidor
                                        </button>
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
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-base-content/70">No hay paquetes pendientes</h3>
                    <p class="text-base-content/50 mt-2">Intenta cambiar los filtros o crea un nuevo envío</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal for New Shipment - Multi-Step Wizard -->
    @if($showModal)
        <div class="modal modal-open">
            <div class="modal-box max-w-lg border border-base-300">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-base-content">Nuevo Envío</h2>
                    <button wire:click="closeModal" class="btn btn-sm btn-circle btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Step Indicator -->
                <div class="mb-8">
                    <ul class="steps steps-horizontal w-full">
                        <li class="step {{ $currentStep >= 1 ? 'step-secondary' : '' }}">Emisor</li>
                        <li class="step {{ $currentStep >= 2 ? 'step-secondary' : '' }}">Receptor</li>
                        <li class="step {{ $currentStep >= 3 ? 'step-secondary' : '' }}">Paquete</li>
                    </ul>
                </div>

                <form wire:submit.prevent="save">
                    <!-- Step 1: Sender Information -->
                    @if($currentStep === 1)
                        <div class="space-y-6" x-data="locationPicker(@entangle('sender_lat'), @entangle('sender_lng'))"
                            x-init="initMap()">
                            <h3 class="text-xl font-semibold text-base-content mb-4">Información del Emisor</h3>

                            <!-- Search Client -->
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="sender_search"
                                    class="input input-bordered w-full" placeholder="Nombre o DUI del emisor" />
                                @if(!empty($sender_suggestions))
                                    <ul
                                        class="menu bg-base-100 w-full rounded-box border border-base-300 absolute z-50 shadow-lg mt-1">
                                        @foreach($sender_suggestions as $client)
                                            <li>
                                                <a wire:click="selectSender({{ $client->id }})">
                                                    {{ $client->nombre }} {{ $client->apellido }} - {{ $client->dui }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            @if($sender_id)
                                <div class="alert alert-info shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        class="stroke-current shrink-0 w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h3 class="font-bold">Cliente Seleccionado</h3>
                                        <div class="text-xs">Editando información de {{ $sender_nombre }} {{ $sender_apellido }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-ghost"
                                        wire:click="$set('sender_id', null)">Cambiar</button>
                                </div>
                            @endif

                            <!-- Nombre -->
                            <div class="relative group">
                                <input type="text" wire:model="sender_nombre" id="sender_nombre"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_nombre') border-error @enderror"
                                    placeholder=" " />
                                <label for="sender_nombre"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Nombre <span class="text-error">*</span>
                                </label>
                                @error('sender_nombre') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Apellido -->
                            <div class="relative group">
                                <input type="text" wire:model="sender_apellido" id="sender_apellido"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_apellido') border-error @enderror"
                                    placeholder=" " />
                                <label for="sender_apellido"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Apellido <span class="text-error">*</span>
                                </label>
                                @error('sender_apellido') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="relative group">
                                <textarea wire:model="sender_direccion" id="sender_direccion" rows="2"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_direccion') border-error @enderror"
                                    placeholder=" "></textarea>
                                <label for="sender_direccion"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Dirección <span class="text-error">*</span>
                                </label>
                                @error('sender_direccion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Teléfono -->
                            <div class="relative group">
                                <input type="tel" wire:model.blur="sender_telefono" id="sender_telefono" maxlength="9"
                                    x-on:input="$el.value = $el.value.replace(/\D/g, '').substring(0, 8).replace(/^(\d{4})(\d)/, '$1-$2')"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_telefono') border-error @enderror"
                                    placeholder="0000-0000" />
                                <label for="sender_telefono"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Teléfono <span class="text-error">*</span>
                                </label>
                                @error('sender_telefono') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="relative group">
                                <input type="email" wire:model="sender_email" id="sender_email"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_email') border-error @enderror"
                                    placeholder=" " />
                                <label for="sender_email"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Email
                                </label>
                                @error('sender_email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- DUI -->
                            <div class="relative group">
                                <input type="text" wire:model.blur="sender_dui" id="sender_dui" maxlength="10"
                                    x-on:input="$el.value = $el.value.replace(/\D/g, '').substring(0, 9).replace(/^(\d{8})(\d)/, '$1-$2')"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_dui') border-error @enderror"
                                    placeholder="00000000-0" />
                                <label for="sender_dui"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    DUI
                                </label>
                                @error('sender_dui') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- NIT -->
                            <div class="relative group">
                                <input type="text" wire:model.blur="sender_nit" id="sender_nit" maxlength="17" x-on:input="
                                                let v = $el.value.replace(/\D/g, '').substring(0, 14);
                                                if (v.length > 13) v = v.replace(/^(\d{4})(\d{6})(\d{3})(\d)/, '$1-$2-$3-$4');
                                                else if (v.length > 10) v = v.replace(/^(\d{4})(\d{6})(\d)/, '$1-$2-$3');
                                                else if (v.length > 4) v = v.replace(/^(\d{4})(\d)/, '$1-$2');
                                                $el.value = v;
                                            "
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_nit') border-error @enderror"
                                    placeholder="0000-000000-000-0" />
                                <label for="sender_nit"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    NIT
                                </label>
                                @error('sender_nit') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <!-- Step 2: Receiver Information -->
                    @if($currentStep === 2)
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-base-content mb-4">Información del Receptor</h3>

                            <!-- Search Client -->
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="receiver_search"
                                    class="input input-bordered w-full" placeholder="Nombre o DUI del receptor" />
                                @if(!empty($receiver_suggestions))
                                    <ul
                                        class="menu bg-base-100 w-full rounded-box border border-base-300 absolute z-50 shadow-lg mt-1">
                                        @foreach($receiver_suggestions as $client)
                                            <li>
                                                <a wire:click="selectReceiver({{ $client->id }})">
                                                    {{ $client->nombre }} {{ $client->apellido }} - {{ $client->dui }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            @if($receiver_id)
                                <div class="alert alert-info shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        class="stroke-current shrink-0 w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h3 class="font-bold">Cliente Seleccionado</h3>
                                        <div class="text-xs">Editando información de {{ $receiver_nombre }} {{ $receiver_apellido }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-ghost"
                                        wire:click="$set('receiver_id', null)">Cambiar</button>
                                </div>
                            @endif

                            <!-- Nombre -->
                            <div class="relative group">
                                <input type="text" wire:model="receiver_nombre" id="receiver_nombre"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_nombre') border-error @enderror"
                                    placeholder=" " />
                                <label for="receiver_nombre"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Nombre <span class="text-error">*</span>
                                </label>
                                @error('receiver_nombre') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Apellido -->
                            <div class="relative group">
                                <input type="text" wire:model="receiver_apellido" id="receiver_apellido"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_apellido') border-error @enderror"
                                    placeholder=" " />
                                <label for="receiver_apellido"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Apellido <span class="text-error">*</span>
                                </label>
                                @error('receiver_apellido') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="relative group">
                                <textarea wire:model="receiver_direccion" id="receiver_direccion" rows="2"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_direccion') border-error @enderror"
                                    placeholder=" "></textarea>
                                <label for="receiver_direccion"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Dirección <span class="text-error">*</span>
                                </label>
                                @error('receiver_direccion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div class="relative group">
                                <input type="tel" wire:model.blur="receiver_telefono" id="receiver_telefono" maxlength="9"
                                    x-on:input="$el.value = $el.value.replace(/\D/g, '').substring(0, 8).replace(/^(\d{4})(\d)/, '$1-$2')"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_telefono') border-error @enderror"
                                    placeholder="0000-0000" />
                                <label for="receiver_telefono"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Teléfono <span class="text-error">*</span>
                                </label>
                                @error('receiver_telefono') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="relative group">
                                <input type="email" wire:model="receiver_email" id="receiver_email"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_email') border-error @enderror"
                                    placeholder=" " />
                                <label for="receiver_email"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Email
                                </label>
                                @error('receiver_email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- DUI -->
                            <div class="relative group">
                                <input type="text" wire:model.blur="receiver_dui" id="receiver_dui" maxlength="10"
                                    x-on:input="$el.value = $el.value.replace(/\D/g, '').substring(0, 9).replace(/^(\d{8})(\d)/, '$1-$2')"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_dui') border-error @enderror"
                                    placeholder="00000000-0" />
                                <label for="receiver_dui"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    DUI
                                </label>
                                @error('receiver_dui') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- NIT -->
                            <div class="relative group">
                                <input type="text" wire:model.blur="receiver_nit" id="receiver_nit" maxlength="17" x-on:input="
                                                let v = $el.value.replace(/\D/g, '').substring(0, 14);
                                                if (v.length > 13) v = v.replace(/^(\d{4})(\d{6})(\d{3})(\d)/, '$1-$2-$3-$4');
                                                else if (v.length > 10) v = v.replace(/^(\d{4})(\d{6})(\d)/, '$1-$2-$3');
                                                else if (v.length > 4) v = v.replace(/^(\d{4})(\d)/, '$1-$2');
                                                $el.value = v;
                                            "
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_nit') border-error @enderror"
                                    placeholder="0000-000000-000-0" />
                                <label for="receiver_nit"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    NIT
                                </label>
                                @error('receiver_nit') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <!-- Step 3: Package Information -->
                    @if($currentStep === 3)
                        <div class="space-y-6" x-data="locationPicker(@entangle('receiver_lat'), @entangle('receiver_lng'))"
                            x-init="initMap()">
                            <h3 class="text-xl font-semibold text-base-content mb-4">Información del Paquete</h3>

                            <!-- Descripción -->
                            <div class="relative group">
                                <textarea wire:model="descripcion" id="descripcion" rows="3"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('descripcion') border-error @enderror"
                                    placeholder=" "></textarea>
                                <label for="descripcion"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Descripción del Paquete <span class="text-error">*</span>
                                </label>
                                @error('descripcion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Peso -->
                            <div class="relative group">
                                <input type="number" step="0.01" wire:model="peso" id="peso"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('peso') border-error @enderror"
                                    placeholder=" " />
                                <label for="peso"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Peso (kg) <span class="text-error">*</span>
                                </label>
                                @error('peso') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Dimensiones -->
                            <div class="relative group">
                                <input type="text" wire:model.blur="dimensiones" id="dimensiones"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('dimensiones') border-error @enderror"
                                    placeholder="Ej: 30x20x15 o 9000" />
                                <label for="dimensiones"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                    Dimensiones (cm) o Volumen (cm³)
                                </label>
                                @error('dimensiones') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tipo de Envío -->
                            <div class="relative group">
                                <select wire:model="tipo_envio_id" id="tipo_envio_id"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('tipo_envio_id') border-error @enderror">
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tiposEnvio as $tipo)
                                        <option value="{{ $tipo->id }}">{{ ucfirst($tipo->nombre) }}</option>
                                    @endforeach
                                </select>
                                <label for="tipo_envio_id"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary left-1">
                                    Tipo de Envío <span class="text-error">*</span>
                                </label>
                                @error('tipo_envio_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Fecha Estimada -->
                            <div class="relative group">
                                <input type="date" wire:model="fecha_estimada" id="fecha_estimada"
                                    min="{{ \Carbon\Carbon::now()->setTimezone('America/El_Salvador')->format('Y-m-d') }}"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('fecha_estimada') border-error @enderror"
                                    placeholder=" " />
                                <label for="fecha_estimada"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary left-1">
                                    Fecha Estimada de Entrega <span class="text-error">*</span>
                                </label>
                                @error('fecha_estimada') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Coordenadas (Latitud/Longitud) -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Ubicación de Entrega</span>
                                    <span class="label-text-alt text-base-content/60"
                                        x-text="lat && lng ? 'Ubicación seleccionada' : 'Seleccione ubicación en el mapa'"></span>
                                </label>
                                <div id="receiver-map" class="leaflet-map border border-base-300 mb-4" wire:ignore></div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative group">
                                        <input type="text" wire:model="receiver_lat" id="receiver_lat_input " required
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer"
                                            placeholder=" " readonly hidden />

                                    </div>
                                    <div class="relative group">
                                        <input type="text" wire:model="receiver_lng" id="receiver_lng_input " required
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer"
                                            placeholder=" " readonly hidden />

                                    </div>
                                </div>
                            </div>

                            {{-- Calculate Cost Button --}}
                            <div class="flex justify-end mb-4">
                                <button type="button" wire:click="calculateCost" class="btn btn-secondary btn-sm gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Calcular Costo
                                </button>
                            </div>

                            {{-- Cost Calculation Display --}}
                            @if($costo_calculado > 0)
                                <div class="card bg-primary/10 border border-primary/20">
                                    <div class="card-body p-4">
                                        <h4 class="font-semibold text-lg mb-2 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Costo Calculado
                                        </h4>
                                        <div class="space-y-2 text-sm">
                                            @if($tipo_envio_id)
                                                @php
                                                    $tipoEnvio = \App\Models\TipoEnvio::find($tipo_envio_id);
                                                @endphp
                                                <div class="flex justify-between">
                                                    <span class="text-base-content/70">Tarifa Base:</span>
                                                    <span class="font-mono">${{ number_format($tipoEnvio->tarifa_base ?? 0, 2) }}</span>
                                                </div>
                                                @if($peso)
                                                    <div class="flex justify-between">
                                                        <span class="text-base-content/70">Peso ({{ $peso }} kg ×
                                                            {{ number_format(($tipoEnvio->tarifa_por_kg ?? 0) / 100, 2) }}):</span>
                                                        <span
                                                            class="font-mono">${{ number_format($peso * (($tipoEnvio->tarifa_por_kg ?? 0) / 100), 2) }}</span>
                                                    </div>
                                                @endif
                                                @if($volumen_m3 > 0 || $dimensiones)
                                                    <div class="flex justify-between">
                                                        <span class="text-base-content/70">Volumen ({{ number_format($volumen_m3, 2) }} cm³
                                                            × {{ number_format(($tipoEnvio->tarifa_por_m3 ?? 0) / 100, 2) }}):</span>
                                                        <span
                                                            class="font-mono">${{ number_format($volumen_m3 * (($tipoEnvio->tarifa_por_m3 ?? 0) / 100), 2) }}</span>
                                                    </div>
                                                @endif
                                                <div class="divider my-2"></div>
                                            @endif
                                            <div class="flex justify-between items-center">
                                                <span class="font-bold text-lg">Total:</span>
                                                <span
                                                    class="font-bold text-2xl text-primary">${{ number_format($costo_calculado, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Email Notification Option (Step 3 only) -->
                    @if($currentStep === 3)
                        <div class="form-control mt-6 mb-4">
                            <label
                                class="label cursor-pointer justify-start gap-3 p-4 border border-base-300 rounded-lg hover:bg-base-200 transition">
                                <input type="checkbox" wire:model="send_email_notification"
                                    class="checkbox checkbox-secondary" />
                                <div class="flex-1">
                                    <span class="label-text font-semibold text-base">Enviar código de paquete por correo
                                        electrónico</span>
                                    <p class="text-sm text-base-content/60 mt-1">
                                        Se enviará una notificación con el código de seguimiento al emisor y receptor (solo si
                                        tienen correo electrónico registrado)
                                    </p>
                                </div>
                            </label>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center mt-8">
                        @if($currentStep > 1)
                            <button type="button" wire:click="previousStep" class="btn btn-ghost rounded-full font-bold">
                                Anterior
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($currentStep < 3)
                            <button type="button" wire:click="nextStep"
                                class="w-full btn btn-outline rounded-full py-2.5 px-4 font-bold transition {{ $currentStep > 1 ? 'max-w-xs' : '' }}">
                                Siguiente
                            </button>
                        @else
                            <button type="submit"
                                class="w-full btn btn-outline rounded-full py-2.5 px-4 font-bold transition max-w-xs">
                                Crear Envío
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Driver Assignment Modal -->
    @if($showAssignModal)
        <div class="modal modal-open">
            <div class="modal-box max-w-2xl border border-base-300">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-base-content">Asignar Repartidor</h2>
                    <button wire:click="closeAssignModal" class="btn btn-sm btn-circle btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @if(session()->has('error'))
                    <div class="alert alert-error mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form wire:submit.prevent="assignDriver">
                    @if($availableDrivers->count() > 0)
                        <div class="space-y-4">
                            <p class="text-base-content/70 mb-4">Selecciona un repartidor con vehículo disponible:</p>

                            @foreach($availableDrivers as $driver)
                                @php
                                    $vehicle = $driver->vehiculoActivo();
                                @endphp
                                <label
                                    class="flex items-center gap-4 p-4 border border-base-300 rounded-lg cursor-pointer hover:bg-base-200 transition {{ $selectedDriverId == $driver->id ? 'bg-secondary/10 border-secondary' : '' }}">
                                    <input type="radio" wire:model.live="selectedDriverId" value="{{ $driver->id }}"
                                        class="radio radio-secondary" />
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar hidden placeholder">
                                                <div class="bg-secondary text-secondary-content rounded-full w-12">
                                                    <span
                                                        class="text-xl">{{ substr($driver->nombre, 0, 1) }}{{ substr($driver->apellido, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-lg">{{ $driver->nombre }} {{ $driver->apellido }}</div>
                                                <div class="text-sm text-base-content/60">{{ $driver->email }}</div>
                                            </div>
                                        </div>
                                        @if($vehicle)
                                            <div class="mt-3 flex items-center gap-2 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-secondary">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                                </svg>
                                                <span class="font-medium">{{ $vehicle->marca }} {{ $vehicle->modelo }}</span>
                                                <span class="badge badge-sm">{{ $vehicle->numero_placas }}</span>
                                                <span class="text-base-content/60">• Capacidad: {{ $vehicle->capacidad_kg }} kg</span>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="modal-action">
                            <button type="button" wire:click="closeAssignModal" class="btn btn-ghost rounded-full font-bold">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary rounded-full font-bold gap-2"
                                @disabled(!$selectedDriverId)>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                Asignar Repartidor
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-16 h-16 mx-auto text-base-content/30 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-base-content/70">No hay repartidores disponibles</h3>
                            <p class="text-base-content/50 mt-2">Todos los repartidores están ocupados o no tienen vehículos
                                asignados</p>
                            <button type="button" wire:click="closeAssignModal"
                                class="btn btn-ghost rounded-full font-bold mt-4">
                                Cerrar
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @endif

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            const registerLocationPicker = () => {
                // Check if already registered to avoid errors
                if (Alpine.data('locationPicker')) return;

                Alpine.data('locationPicker', (latModel, lngModel) => ({
                    lat: latModel,
                    lng: lngModel,
                    map: null,
                    marker: null,

                    initMap() {
                        // Wait for DOM to be ready and modal transition
                        setTimeout(() => {
                            const mapContainer = this.$el.querySelector('.leaflet-map');
                            if (!mapContainer) {
                                return;
                            }

                            // Fix: Check if map is already initialized on this element
                            if (mapContainer._leaflet_map) {
                                mapContainer._leaflet_map.remove();
                                mapContainer._leaflet_map = null;
                            }

                            // Remove existing map from Alpine state if any
                            if (this.map) {
                                this.map.remove();
                                this.map = null;
                                this.marker = null;
                            }

                            // Ensure L (Leaflet) is available
                            if (typeof L === 'undefined') {
                                console.error('Leaflet is not loaded');
                                return;
                            }

                            // Default to El Salvador coordinates or current selection
                            const initialLat = this.lat || 13.6929;
                            const initialLng = this.lng || -89.2182;
                            const zoom = this.lat && this.lng ? 15 : 13;

                            this.map = L.map(mapContainer).setView([initialLat, initialLng], zoom);
                            mapContainer._leaflet_map = this.map;

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(this.map);

                            if (this.lat && this.lng) {
                                this.marker = L.marker([this.lat, this.lng]).addTo(this.map);
                            }

                            this.map.on('click', (e) => {
                                const {
                                    lat,
                                    lng
                                } = e.latlng;
                                this.lat = lat;
                                this.lng = lng;

                                if (this.marker) {
                                    this.marker.setLatLng([lat, lng]);
                                } else {
                                    this.marker = L.marker([lat, lng]).addTo(this.map);
                                }
                            });

                            // Invalidate size to handle modal rendering issues
                            setTimeout(() => {
                                if (this.map) {
                                    this.map.invalidateSize();
                                }
                            }, 200);
                        }, 200);
                    }
                }));
            };

            // Safe registration pattern
            if (typeof Alpine !== 'undefined') {
                registerLocationPicker();
            } else {
                document.addEventListener('alpine:init', registerLocationPicker);
            }
        </script>
    @endpush
</div>