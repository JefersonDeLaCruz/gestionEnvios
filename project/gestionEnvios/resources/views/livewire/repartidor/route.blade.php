<div class="p-6" x-data="{
    map: null,
    markers: [],
    userMarker: null,
    initMap() {
        // Ensure DOM is ready and container exists
        if (!document.getElementById('map')) return;

        // Small delay to ensure container has size
        setTimeout(() => {
            if (this.map) {
                this.map.remove();
            }

            this.map = L.map('map').setView([13.6929, -89.2182], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors'
            }).addTo(this.map);

            // Force map resize calculation
            this.map.invalidateSize();

            // Get user location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const { latitude, longitude } = position.coords;
                        this.userMarker = L.circleMarker([latitude, longitude], {
                            radius: 8,
                            fillColor: '#3b82f6',
                            color: '#fff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(this.map);
                        
                        // Only center if no package selected
                        if ({{ $selectedEnvio ? 'false' : 'true' }}) {
                            this.map.setView([latitude, longitude], 13);
                        }
                    },
                    (error) => {
                        console.error('Error getting location:', error);
                    }
                );
            }
        }, 100);
    },
    updateMap(lat, lng, address) {
        if (!this.map) this.initMap();
        
        // Clear existing destination markers
        this.markers.forEach(m => this.map.removeLayer(m));
        this.markers = [];
        
        // Add new marker
        const marker = L.marker([lat, lng]).addTo(this.map)
            .bindPopup(address)
            .openPopup();
        this.markers.push(marker);
        
        this.map.setView([lat, lng], 16);
    }
}" x-init="initMap()" @envio-selected.window="updateMap($event.detail.lat, $event.detail.lng, $event.detail.address)">

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            #map {
                height: 100%;
                width: 100%;
                z-index: 1;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @endpush

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Ruta del Día</h1>
        <p class="text-base-content/70 mt-1">Planificación y seguimiento de tu ruta de entregas</p>
    </div>

    <!-- Route Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="stats shadow">
            <div class="stat place-items-center">
                <div class="stat-title">Total Paquetes</div>
                <div class="stat-value text-primary">{{ $stats['total'] ?? 0 }}</div>
                <div class="stat-desc">Asignados hoy</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat place-items-center">
                <div class="stat-title">Entregados</div>
                <div class="stat-value text-success">{{ $stats['entregados'] ?? 0 }}</div>
                <div class="stat-desc text-success">Completados</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat place-items-center">
                <div class="stat-title">Pendientes</div>
                <div class="stat-value text-warning">{{ $stats['pendientes'] ?? 0 }}</div>
                <div class="stat-desc text-warning">Por entregar</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat place-items-center">
                <div class="stat-title">Progreso</div>
                <div class="stat-value text-accent">{{ $stats['progreso'] ?? 0 }}%</div>
                <div class="stat-desc">Del total</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Map Section -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl h-full">
                <div class="card-body p-0 overflow-hidden relative h-[500px] rounded-box">
                    <div id="map" class="h-full w-full" wire:ignore></div>

                    <!-- Map Controls Overlay -->
                    <div class="absolute bottom-4 left-4 right-4 z-1000 flex justify-between pointer-events-none">
                        <div class="pointer-events-auto">
                            @if($selectedEnvio)
                                <div
                                    class="bg-base-100/90 backdrop-blur p-3 rounded-lg shadow-lg border border-base-200 max-w-xs">
                                    <h3 class="font-bold text-sm">{{ $selectedEnvio->paquete->codigo }}</h3>
                                    <p class="text-xs opacity-70 truncate">
                                        {{ $selectedEnvio->paquete->direccion ?? 'Sin dirección' }}
                                    </p>
                                    <div class="mt-2 flex gap-2">
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $selectedEnvio->paquete->latitud }},{{ $selectedEnvio->paquete->longitud }}"
                                            target="_blank" class="btn btn-primary btn-xs gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-3 h-3">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Navegar
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Route Stops List -->
        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="card-title">Paradas</h2>
                        <select class="select select-bordered select-sm">
                            <option>Todas</option>
                            <option>Pendientes</option>
                            <option>Completadas</option>
                        </select>
                    </div>

                    <div class="overflow-y-auto max-h-96 space-y-3">
                        @forelse($envios as $envio)
                            @php
                                $receptor = $this->getReceptor($envio);
                                $priority = $envio->paquete->tipoEnvio->prioridad ?? 999;
                                $isHighPriority = $priority <= 1;
                            @endphp
                            <div wire:click="selectEnvio({{ $envio->id }})"
                                class="flex items-start gap-3 p-3 rounded-lg cursor-pointer transition-all {{ $selectedEnvio && $selectedEnvio->id == $envio->id ? 'bg-primary/10 border border-primary' : 'bg-base-200 hover:bg-base-300' }} {{ $isHighPriority ? 'border-l-4 border-l-error' : '' }}">

                                @php
                                    $statusColor = match ($envio->estadoEnvio->slug ?? '') {
                                        'entregado' => 'success',
                                        'pendiente' => 'warning',
                                        'no-entregado' => 'error',
                                        default => 'ghost'
                                    };
                                    $statusIcon = match ($envio->estadoEnvio->slug ?? '') {
                                        'entregado' => '✓',
                                        'pendiente' => '→',
                                        'no-entregado' => '✕',
                                        default => '?'
                                    };
                                @endphp

                                <div class="badge badge-{{ $statusColor }} badge-lg">{{ $statusIcon }}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div class="font-semibold text-sm truncate">{{ $envio->paquete->codigo }}</div>
                                        @if($isHighPriority)
                                            <span class="badge badge-error badge-xs text-white">Prioridad</span>
                                        @endif
                                    </div>
                                    <div class="text-xs font-medium text-base-content/80 truncate">
                                        {{ $receptor ? $receptor->nombre . ' ' . $receptor->apellido : 'Cliente Desconocido' }}
                                    </div>
                                    <div class="text-xs text-base-content/60 mt-1 truncate">
                                        {{ $receptor->direccion ?? ($envio->paquete->direccion ?? 'Sin dirección') }}
                                    </div>
                                    <div class="text-xs text-{{ $statusColor }} mt-1 font-semibold">
                                        {{ $envio->estadoEnvio->nombre ?? 'Desconocido' }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-base-content/50">
                                No tienes paquetes asignados hoy.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Route Timeline -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title mb-4">Detalles del Paquete</h2>
            @if($selectedEnvio)
                @php
                    $receptor = $this->getReceptor($selectedEnvio);
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">{{ $selectedEnvio->paquete->codigo }}</h3>
                                <p class="text-base-content/70">{{ $selectedEnvio->paquete->descripcion }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-primary">
                                    {{ $selectedEnvio->paquete->tipoEnvio->nombre ?? 'Envío' }}</div>
                                @if(($selectedEnvio->paquete->tipoEnvio->prioridad ?? 999) <= 1)
                                    <div class="badge badge-error text-white text-xs">Alta Prioridad</div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-base-200 rounded-lg space-y-2">
                            <h4 class="font-bold text-sm uppercase text-base-content/50 mb-2">Información de Entrega</h4>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 opacity-70">
                                    <path
                                        d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                                <span
                                    class="font-medium">{{ $receptor ? $receptor->nombre . ' ' . $receptor->apellido : 'N/A' }}</span>
                            </div>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 opacity-70">
                                    <path fill-rule="evenodd"
                                        d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $receptor->telefono ?? 'N/A' }}</span>
                            </div>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 opacity-70">
                                    <path fill-rule="evenodd"
                                        d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.625a19.055 19.055 0 002.274 1.765c.311.193.571.337.757.433.092.047.185.094.281.14l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span
                                    class="text-sm">{{ $receptor->direccion ?? ($selectedEnvio->paquete->direccion ?? 'Sin dirección') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium">Estado:</span>
                                <span
                                    class="badge badge-{{ match ($selectedEnvio->estadoEnvio->slug ?? '') { 'entregado' => 'success', 'pendiente' => 'warning', 'no-entregado' => 'error', default => 'ghost'} }}">
                                    {{ $selectedEnvio->estadoEnvio->nombre ?? 'Desconocido' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium">Peso:</span>
                                <span>{{ $selectedEnvio->paquete->peso }} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium">Dimensiones:</span>
                                <span>{{ $selectedEnvio->paquete->dimensiones }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-bold text-sm uppercase text-base-content/50 mb-3">Actualizar Estado</h4>
                            <div class="join w-full grid grid-cols-3">
                                <button wire:click="openModal({{ $selectedEnvio->id }}, &quot;entregado&quot;)" 
                                        class="btn join-item {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'entregado' ? 'btn-success text-white' : 'btn-outline btn-success' }}"
                                        {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'entregado' ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="hidden sm:inline">Entregado</span>
                                </button>
                                <button wire:click="openModal({{ $selectedEnvio->id }}, &quot;no-entregado&quot;)" 
                                        class="btn join-item {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'no-entregado' ? 'btn-error text-white' : 'btn-outline btn-error' }}"
                                        {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'no-entregado' ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="hidden sm:inline">Fallido</span>
                                </button>
                                <button wire:click="openModal({{ $selectedEnvio->id }}, &quot;pendiente&quot;)" 
                                        class="btn join-item {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'pendiente' ? 'btn-warning text-white' : 'btn-outline btn-warning' }}"
                                        {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'pendiente' ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="hidden sm:inline">Pendiente</span>
                                </button>
                            </div>
                            @if(($selectedEnvio->estadoEnvio->slug ?? '') == 'entregado')
                                <div class="alert alert-success mt-3 shadow-sm text-sm py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>¡Paquete entregado exitosamente!</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold mb-2">Historial</h4>
                        <ul class="steps steps-vertical w-full">
                            @foreach($selectedEnvio->historialEnvios->sortByDesc('created_at') as $historial)
                                <li class="step step-primary">
                                    <div class="text-left w-full">
                                        <div class="font-bold text-sm">{{ $historial->created_at->format('d/m/Y H:i') }}</div>
                                        <div class="text-xs">{{ $historial->descripcion }}</div>
                                    </div>
                                </li>
                            @endforeach
                            <li class="step step-neutral">
                                <div class="text-left w-full">
                                    <div class="font-bold text-sm">{{ $selectedEnvio->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="text-xs">Envío creado</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="text-center py-10 text-base-content/50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-16 h-16 mx-auto mb-4 opacity-30">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    Selecciona un paquete para ver detalles y gestionar su estado.
                </div>
            @endif
        </div>
    </div>

    <!-- Status Update Modal -->
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Confirmar Cambio de Estado</h3>
            <p class="py-4">Estás a punto de cambiar el estado a: 
                <span class="font-bold badge badge-lg">
                    {{ \App\Models\EstadoEnvio::find($newStatusId)->nombre ?? 'Desconocido' }}
                </span>
            </p>

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Comentario (Obligatorio)</span>
                </label>
                <textarea wire:model="comment" class="textarea textarea-bordered h-24"
                    placeholder="Describe el motivo del cambio..."></textarea>
                @error('comment') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            @php
                $statusSlug = \App\Models\EstadoEnvio::find($newStatusId)->slug ?? '';
            @endphp

            @if($statusSlug === 'entregado')
            <div class="form-control w-full mt-4">
                <label class="label">
                    <span class="label-text">Foto de Entrega (Obligatorio)</span>
                </label>
                <input type="file" wire:model="photo" class="file-input file-input-bordered w-full" accept="image/*" />
                @error('photo') <span class="text-error text-sm">{{ $message }}</span> @enderror
                <div wire:loading wire:target="photo" class="text-sm text-info mt-2">Subiendo foto...</div>
            </div>
            @endif

            <div class="modal-action">
                <button wire:click="$set('showModal', false)" class="btn">Cancelar</button>
                <button wire:click="saveStatus" class="btn btn-primary" wire:loading.attr="disabled">Confirmar</button>
            </div>
        </div>
    </div>
    @endif
</div>