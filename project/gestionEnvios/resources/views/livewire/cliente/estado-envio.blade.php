<div class="w-full">

    <!-- Search Form Section -->
    <div class="w-full max-w-md mx-auto mb-8">
        <form wire:submit.prevent="buscarPaquete" class="flex flex-col gap-4">
            <label class="label">
                <span class="label-text text-base">Código de Seguimiento</span>
            </label>

            <!-- Input y botón en una sola fila -->
            <div class="flex gap-2">
                <input type="text" wire:model.defer="codigoPaquete" placeholder="Ej: PKG-12345678"
                    class="input input-bordered flex-1 border-gray-700 focus:border-secondary focus:outline-none" />

                <button type="submit" class="btn btn-secondary border-none" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="buscarPaquete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rastrear paquete
                    </span>
                    <span wire:loading wire:target="buscarPaquete" class="loading loading-spinner loading-sm"></span>
                </button>
            </div>

            <!-- Error debajo del input -->
            @error('codigoPaquete')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror

            <!-- Botón limpiar -->
            @if($busquedaRealizada)
                <button type="button" wire:click="limpiarBusqueda" class="btn btn-outline w-full">
                    Limpiar
                </button>
            @endif
        </form>
    </div>
    <!-- Results Section -->
    @if($busquedaRealizada)
        <div wire:poll.5s="refreshData">
            @if($noEncontrado)
                <!-- Not Found State -->
                <div class="alert alert-warning max-w-2xl mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="font-bold">Paquete no encontrado</h3>
                        <div class="text-sm">No se encontró ningún paquete con el código: <strong>{{ $codigoPaquete }}</strong>
                        </div>
                        <div class="text-xs mt-1 opacity-70">Por favor verifica el código e intenta nuevamente.</div>
                    </div>
                </div>
            @elseif($paquete)
                <!-- Package Found - Display Results -->
                <div class="w-full max-w-7xl mx-auto space-y-6">

                    <!-- Package Info Card -->
                    <div class="card bg-base-200 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title text-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-secondary" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Paquete: {{ $paquete->codigo }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <p class="text-sm opacity-70">Descripción</p>
                                    <p class="font-semibold">{{ $paquete->descripcion }}</p>
                                </div>
                                <div>
                                    <p class="text-sm opacity-70">Peso</p>
                                    <p class="font-semibold">{{ $paquete->peso }} kg</p>
                                </div>
                                <div>
                                    <p class="text-sm opacity-70">Dimensiones</p>
                                    <p class="font-semibold">{{ $paquete->dimensiones }}</p>
                                </div>
                                @if($envio && $envio->estadoEnvio)
                                    <div>
                                        <p class="text-sm opacity-70">Estado Actual</p>
                                        <div class="badge badge-lg badge-secondary mt-1">{{ $envio->estadoEnvio->nombre }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- Package Status Timeline -->
                    <div class="card bg-base-200 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                Estado del Envío
                            </h3>

                            <ul class="timeline timeline-vertical">
                                @if($historial && $historial->count() > 0)
                                        @foreach($historial as $index => $item)
                                        @php
                                            $isCompleted = $index < $historial->count() - 1;
                                            $isCurrent = $index === $historial->count() - 1;
                                            $slug = $item->estadoEnvio->slug ?? '';
                                            
                                            // Determine styles and icons based on status
                                            $statusConfig = match($slug) {
                                                'en-bodega' => ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => 'neutral', 'label' => 'En Bodega Central'],
                                                'asignado' => ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => 'info', 'label' => 'Recolectado'],
                                                'en-ruta' => ['icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0', 'color' => 'warning', 'label' => 'En Ruta de Entrega'],
                                                'entregado' => ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'success', 'label' => 'Entregado'],
                                                'no-entregado' => ['icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'error', 'label' => 'Entrega Fallida'],
                                                default => ['icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'base-content', 'label' => $item->estadoEnvio->nombre]
                                            };

                                            $statusClass = $statusConfig['color'];
                                            $icon = $statusConfig['icon'];
                                            $label = $statusConfig['label'];
                                        @endphp

                                        <li>
                                            @if($index > 0)
                                                <hr class="bg-{{ $isCompleted ? 'success' : 'base-300' }}" />
                                            @endif

                                            <div class="timeline-start timeline-box">
                                                <div class="font-bold text-sm">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}
                                                </div>
                                                <div class="text-xs opacity-70">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</div>
                                            </div>

                                            <div class="timeline-middle">
                                                <div class="p-2 rounded-full bg-{{ $isCurrent ? $statusClass : ($isCompleted ? 'success' : 'base-200') }} text-{{ $isCurrent || $isCompleted ? 'white' : 'base-content' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="timeline-end timeline-box border-{{ $isCurrent ? $statusClass : 'base-200' }} bg-base-100">
                                                <div class="font-bold {{ $isCurrent ? 'text-'.$statusClass : '' }}">{{ $label }}</div>
                                                @if($item->comentario)
                                                    <div class="text-xs opacity-70 mt-1">{{ $item->comentario }}</div>
                                                @endif
                                            </div>

                                            @if($index < $historial->count() - 1)
                                                <hr class="bg-success" />
                                            @endif
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <div class="timeline-start timeline-box bg-base-200">
                                            <div class="text-sm opacity-70">No hay historial disponible</div>
                                        </div>
                                        <div class="timeline-middle">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-5 h-5 text-base-content/30">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </li>
                                @endif

                                @if($envio && $envio->fecha_estimada && $historial && $historial->count() > 0)
                                    {{-- Estimated delivery time --}}
                                    <li>
                                        <hr class="bg-base-300" />
                                        <div class="timeline-middle">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-5 h-5 text-base-content/30">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="timeline-end timeline-box bg-base-200">
                                            <div class="font-bold text-sm">
                                                ~{{ \Carbon\Carbon::parse($envio->fecha_estimada)->format('h:i A') }} - Entrega
                                                Estimada
                                            </div>
                                            <div class="text-xs opacity-70 mt-1">
                                                {{ \Carbon\Carbon::parse($envio->fecha_estimada)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Shipment Details and History -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Current Status Details -->
                        @if($envio)
                            <div class="card bg-base-200 shadow-xl">
                                <div class="card-body">
                                    <h3 class="card-title text-xl mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Detalles del Envío
                                    </h3>

                                    <div class="space-y-3">
                                        @if($envio->fecha_estimada)
                                            <div class="flex items-center gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <div>
                                                    <p class="text-xs opacity-70">Fecha Estimada de Entrega</p>
                                                    <p class="font-semibold">
                                                        {{ \Carbon\Carbon::parse($envio->fecha_estimada)->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($envio->motorista)
                                            <div class="flex items-center gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <div>
                                                    <p class="text-xs opacity-70">Motorista Asignado</p>
                                                    <p class="font-semibold">{{ $envio->motorista->name }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($envio->vehiculo)
                                            <div class="flex items-center gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                                </svg>
                                                <div>
                                                    <p class="text-xs opacity-70">Vehículo</p>
                                                    <p class="font-semibold">{{ $envio->vehiculo->modelo }} -
                                                        {{ $envio->vehiculo->placa }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($envio->costo)
                                            <div class="flex items-center gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>
                                                    <p class="text-xs opacity-70">Costo de Envío</p>
                                                    <p class="font-semibold">${{ number_format($envio->costo, 2) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Status History Timeline -->
                        @if($historial && $historial->count() > 0)
                            <div class="card bg-base-200 shadow-xl">
                                <div class="card-body">
                                    <h3 class="card-title text-xl mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Historial de Estados
                                    </h3>

                                    <ul class="timeline timeline-vertical timeline-compact">
                                        @foreach($historial as $index => $item)
                                            <li>
                                                @if($index > 0)
                                                    <hr class="bg-secondary" />
                                                @endif
                                                <div class="timeline-start text-xs opacity-70">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                                </div>
                                                <div class="timeline-middle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                        class="w-5 h-5 text-secondary">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="timeline-end timeline-box">
                                                    <div class="font-semibold">{{ $item->estadoEnvio->nombre }}</div>
                                                    @if($item->comentario)
                                                        <p class="text-sm opacity-70 mt-1">{{ $item->comentario }}</p>
                                                    @endif
                                                    @if($item->foto_url)
                                                        <div class="mt-2">
                                                            <button wire:click="viewImage('{{ $item->foto_url }}')"
                                                                class="btn btn-xs btn-outline btn-secondary gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                Ver foto
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($index < $historial->count() - 1)
                                                    <hr class="bg-secondary" />
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
    @endif

        {{-- Image Preview Modal --}}
        @if($showImageModal)
            <div class="modal modal-open" style="z-index: 9999;">
                <div class="modal-box relative max-w-4xl flex justify-center items-center bg-transparent shadow-none">
                    <button wire:click="closeImageModal"
                        class="btn btn-circle btn-sm absolute right-2 top-2 bg-base-100 border-none text-base-content hover:bg-base-200 z-50">✕</button>
                    <img src="{{ asset('storage/' . $selectedImageUrl) }}" alt="Evidencia de Entrega"
                        class="max-h-[85vh] rounded-lg shadow-2xl object-contain bg-base-100">
                </div>
                <div class="modal-backdrop bg-black/80" wire:click="closeImageModal"></div>
            </div>
        @endif
    </div>