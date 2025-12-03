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

    @if (session()->has('message'))
    <div class="alert alert-success mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('message') }}</span>
    </div>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Todos los Envíos</h1>
        <button wire:click="openModal" class="btn btn-primary gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nuevo Envío
        </button>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            {{-- Filters --}}
            <div class="flex flex-col md:flex-row gap-4 mb-6 justify-between">
                <div class="form-control w-full md:w-1/3">
                    <div class="input-group">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Buscar por código o cliente..." class="input input-bordered w-full" />
                        <button class="btn btn-square">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="form-control w-full md:w-1/4">
                    <select wire:model.live="statusFilter" class="select select-bordered w-full">
                        <option value="">Todos los estados</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Remitente / Destinatario</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha Estimada</th>
                            <th>Repartidor</th>
                            <th>Costo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $shipment)
                        <tr>
                            <td class="font-bold font-mono">{{ $shipment->paquete->codigo }}</td>
                            <td>
                                <div class="flex flex-col text-sm">
                                    @php
                                    $remitente = $shipment->paquete->envioClientes->where('tipo_cliente', 'emisor')->first()?->cliente;
                                    $destinatario = $shipment->paquete->envioClientes->where('tipo_cliente', 'receptor')->first()?->cliente;
                                    @endphp
                                    <span class="font-semibold">De:
                                        {{ $remitente ? $remitente->nombre . ' ' . $remitente->apellido : 'N/A' }}</span>
                                    <span class="text-base-content/70">Para:
                                        {{ $destinatario ? $destinatario->nombre . ' ' . $destinatario->apellido : 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                {{ $shipment->paquete->tipoEnvio->nombre }}
                            </td>
                            <td>
                                <div class="badge {{ match ($shipment->estadoEnvio->slug ?? '') {
                                'pendiente' => 'badge-warning',
                                'en-transito' => 'badge-info',
                                'entregado' => 'badge-success',
                                'cancelado' => 'badge-error',
                                default => 'badge-ghost'
                            } }} gap-2">
                                    {{ $shipment->estadoEnvio->nombre ?? 'Desconocido' }}
                                </div>
                            </td>
                            <td>{{ $shipment->fecha_estimada ? \Carbon\Carbon::parse($shipment->fecha_estimada)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td>
                                @if($shipment->motorista)
                                <div class="flex items-center gap-2">
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                            <span
                                                class="text-xs">{{ substr($shipment->motorista->nombre, 0, 1) }}{{ substr($shipment->motorista->apellido, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-xs">{{ $shipment->motorista->nombre }}
                                            {{ $shipment->motorista->apellido }}</span>
                                        @if($shipment->vehiculo)
                                        <span
                                            class="text-[10px] opacity-70">{{ $shipment->vehiculo->numero_placas }}</span>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <span class="text-base-content/50 italic text-sm">Sin asignar</span>
                                @endif
                            </td>
                            <td class="font-mono">${{ number_format($shipment->costo, 2) }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <button wire:click="openDetailsModal({{ $shipment->id }})" class="btn btn-ghost btn-xs" title="Ver Detalles">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                    <button wire:click="openAssignModal({{ $shipment->id }})" class="btn btn-ghost btn-xs text-warning" title="Asignar/Cambiar Repartidor">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                        </svg>
                                    </button>
                                    <button wire:click="edit({{ $shipment->id }})" class="btn btn-ghost btn-xs text-info" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $shipment->id }})" wire:confirm="¿Estás seguro de eliminar este envío? Esta acción no se puede deshacer." class="btn btn-ghost btn-xs text-error" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center text-base-content/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                    </svg>
                                    <p>No se encontraron envíos.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $shipments->links() }}
            </div>
        </div>
    </div>

    {{-- Details Modal --}}
    @if($showDetailsModal && $selectedShipment)
    <div class="modal modal-open">
        <div class="modal-box w-11/12 max-w-4xl border border-base-300">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="font-bold text-2xl flex items-center gap-3">
                        Envío #{{ $selectedShipment->paquete->codigo }}
                        <div class="badge {{ match ($selectedShipment->estadoEnvio->slug ?? '') {
            'pendiente' => 'badge-warning',
            'en-transito' => 'badge-info',
            'entregado' => 'badge-success',
            'cancelado' => 'badge-error',
            default => 'badge-ghost'
        } }} badge-lg">
                            {{ $selectedShipment->estadoEnvio->nombre ?? 'Desconocido' }}
                        </div>
                    </h3>
                    <p class="text-base-content/60 text-sm mt-1">
                        Creado el {{ $selectedShipment->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
                <button wire:click="closeDetailsModal" class="btn btn-circle btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Package Info --}}
                <div class="card bg-base-200">
                    <div class="card-body p-4">
                        <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Información del Paquete</h4>
                        <div class="space-y-2">
                            <p><span class="font-semibold">Descripción:</span>
                                {{ $selectedShipment->paquete->descripcion }}
                            </p>
                            <div class="flex gap-4">
                                <p><span class="font-semibold">Peso:</span> {{ $selectedShipment->paquete->peso }} lb
                                </p>
                                <p><span class="font-semibold">Dimensiones:</span>
                                    {{ $selectedShipment->paquete->dimensiones ?? 'N/A' }}
                                </p>
                            </div>
                            <p><span class="font-semibold">Tipo de Envío:</span> <span
                                    class="badge badge-outline capitalize">{{ $selectedShipment->paquete->tipoEnvio->nombre }}</span>
                            </p>
                            <p><span class="font-semibold">Costo:</span>
                                ${{ number_format($selectedShipment->costo, 2) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Logistics Info --}}
                <div class="card bg-base-200">
                    <div class="card-body p-4">
                        <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Logística</h4>
                        <div class="space-y-2">
                            <p><span class="font-semibold">Fecha Estimada:</span>
                                {{ \Carbon\Carbon::parse($selectedShipment->fecha_estimada)->format('d/m/Y') }}
                            </p>
                            @if($selectedShipment->motorista)
                            <div class="flex items-center gap-3 mt-2">
                                <div class="avatar placeholder">
                                    <div class="bg-neutral text-neutral-content rounded-full w-10">
                                        <span>{{ substr($selectedShipment->motorista->nombre, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-bold">{{ $selectedShipment->motorista->nombre }}
                                        {{ $selectedShipment->motorista->apellido }}
                                    </p>
                                    <p class="text-xs opacity-70">Repartidor</p>
                                </div>
                            </div>
                            @if($selectedShipment->vehiculo)
                            <p class="text-sm mt-2"><span class="font-semibold">Vehículo:</span>
                                {{ $selectedShipment->vehiculo->marca }} {{ $selectedShipment->vehiculo->modelo }}
                                ({{ $selectedShipment->vehiculo->numero_placas }})
                            </p>
                            @endif
                            @else
                            <div class="alert alert-warning py-2 text-sm mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Sin repartidor asignado</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sender Info --}}
                @php
                $remitente = $selectedShipment->paquete->envioClientes->where('tipo_cliente', 'emisor')->first()?->cliente;
                @endphp
                <div class="card border border-base-300">
                    <div class="card-body p-4">
                        <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Remitente (Origen)</h4>
                        @if($remitente)
                        <p class="font-bold text-lg">{{ $remitente->nombre }} {{ $remitente->apellido }}</p>
                        <p class="text-sm flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-1 opacity-70" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $remitente->direccion }}
                        </p>
                        <div class="divider my-1"></div>
                        <p class="text-sm"><span class="opacity-70">Tel:</span> {{ $remitente->telefono }}</p>
                        <p class="text-sm"><span class="opacity-70">Email:</span> {{ $remitente->email }}</p>
                        @else
                        <p class="italic opacity-50">Información no disponible</p>
                        @endif
                    </div>
                </div>

                {{-- Receiver Info --}}
                @php
                $destinatario = $selectedShipment->paquete->envioClientes->where('tipo_cliente', 'receptor')->first()?->cliente;
                @endphp
                <div class="card border border-base-300">
                    <div class="card-body p-4">
                        <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Destinatario (Destino)</h4>
                        @if($destinatario)
                        <p class="font-bold text-lg">{{ $destinatario->nombre }} {{ $destinatario->apellido }}</p>
                        <p class="text-sm flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-1 opacity-70" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $destinatario->direccion }}
                        </p>
                        <div class="divider my-1"></div>
                        <p class="text-sm"><span class="opacity-70">Tel:</span> {{ $destinatario->telefono }}</p>
                        <p class="text-sm"><span class="opacity-70">Email:</span> {{ $destinatario->email }}</p>
                        @else
                        <p class="italic opacity-50">Información no disponible</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal-action">
                <button wire:click="closeDetailsModal" class="btn">Cerrar</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal for New/Edit Shipment - Multi-Step Wizard -->
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-lg border border-base-300">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-base-content">{{ $isEditing ? 'Editar Envío' : 'Nuevo Envío' }}</h2>
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
                        <ul class="menu bg-base-100 w-full rounded-box border border-base-300 absolute z-50 shadow-lg mt-1">
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">Cliente Seleccionado</h3>
                            <div class="text-xs">Editando información de {{ $sender_nombre }} {{ $sender_apellido }}</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-ghost" wire:click="$set('sender_id', null)">Cambiar</button>
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
                        <input type="tel" wire:model="sender_telefono" id="sender_telefono"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_telefono') border-error @enderror"
                            placeholder=" " />
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
                        <input type="text" wire:model="sender_dui" id="sender_dui"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_dui') border-error @enderror"
                            placeholder=" " />
                        <label for="sender_dui"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                            DUI
                        </label>
                        @error('sender_dui') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIT -->
                    <div class="relative group">
                        <input type="text" wire:model="sender_nit" id="sender_nit"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('sender_nit') border-error @enderror"
                            placeholder=" " />
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
                        <ul class="menu bg-base-100 w-full rounded-box border border-base-300 absolute z-50 shadow-lg mt-1">
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">Cliente Seleccionado</h3>
                            <div class="text-xs">Editando información de {{ $receiver_nombre }} {{ $receiver_apellido }}</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-ghost" wire:click="$set('receiver_id', null)">Cambiar</button>
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
                        <input type="tel" wire:model="receiver_telefono" id="receiver_telefono"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_telefono') border-error @enderror"
                            placeholder=" " />
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
                        <input type="text" wire:model="receiver_dui" id="receiver_dui"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_dui') border-error @enderror"
                            placeholder=" " />
                        <label for="receiver_dui"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                            DUI
                        </label>
                        @error('receiver_dui') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIT -->
                    <div class="relative group">
                        <input type="text" wire:model="receiver_nit" id="receiver_nit"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('receiver_nit') border-error @enderror"
                            placeholder=" " />
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
                        <input type="text" wire:model="dimensiones" id="dimensiones"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border border-base-300 appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer @error('dimensiones') border-error @enderror"
                            placeholder=" " />
                        <label for="dimensiones"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                            Dimensiones (ej: 30x20x15 cm)
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
                        <input type="date" wire:model="fecha_estimada" id="fecha_estimada" min="{{ \Carbon\Carbon::now()->setTimezone('America/El_Salvador')->format('Y-m-d') }}"
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Calcular Costo
                        </button>
                    </div>

                    {{-- Cost Calculation Display --}}
                    @if($costo_calculado > 0)
                    <div class="card bg-primary/10 border border-primary/20">
                        <div class="card-body p-4">
                            <h4 class="font-semibold text-lg mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                    <span class="text-base-content/70">Peso ({{ $peso }} kg × ${{ number_format($tipoEnvio->tarifa_por_kg ?? 0, 2) }}):</span>
                                    <span class="font-mono">${{ number_format($peso * ($tipoEnvio->tarifa_por_kg ?? 0), 2) }}</span>
                                </div>
                                @endif
                                @if($volumen_m3 > 0)
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Volumen ({{ number_format($volumen_m3, 4) }} m³ × ${{ number_format($tipoEnvio->tarifa_por_m3 ?? 0, 2) }}):</span>
                                    <span class="font-mono">${{ number_format($volumen_m3 * ($tipoEnvio->tarifa_por_m3 ?? 0), 2) }}</span>
                                </div>
                                @endif
                                <div class="divider my-2"></div>
                                @endif
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-lg">Total:</span>
                                    <span class="font-bold text-2xl text-primary">${{ number_format($costo_calculado, 2) }}</span>
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
                    <label class="label cursor-pointer justify-start gap-3 p-4 border border-base-300 rounded-lg hover:bg-base-200 transition">
                        <input type="checkbox" wire:model="send_email_notification" class="checkbox checkbox-secondary" />
                        <div class="flex-1">
                            <span class="label-text font-semibold text-base">Enviar código de paquete por correo electrónico</span>
                            <p class="text-sm text-base-content/60 mt-1">
                                Se enviará una notificación con el código de seguimiento al emisor y receptor (solo si tienen correo electrónico registrado)
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
                            {{ $isEditing ? 'Actualizar Envío' : 'Crear Envío' }}
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
                                <div class="avatar placeholder">
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
        document.addEventListener('alpine:init', () => {
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

                        // Force map resize to fix gray tiles issue
                        setTimeout(() => {
                            this.map.invalidateSize();
                        }, 200);
                    }, 300);
                }
            }));
        });
    </script>
    @endpush
</div>