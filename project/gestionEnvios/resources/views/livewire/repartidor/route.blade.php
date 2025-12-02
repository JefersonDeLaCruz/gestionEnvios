<div class="p-6" x-data="{
    map: null,
    markers: [],
    userMarker: null,
    initMap() {
        // Default to San Salvador if no location
        this.map = L.map('map').setView([13.6929, -89.2182], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(this.map);

        // Try to get user location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                if (this.userMarker) this.map.removeLayer(this.userMarker);
                
                const userIcon = L.divIcon({
                    className: 'bg-primary rounded-full border-2 border-white shadow-lg',
                    iconSize: [12, 12]
                });

                this.userMarker = L.marker([lat, lng], {icon: userIcon}).addTo(this.map)
                    .bindPopup('Tu ubicación');
                
                // Only center if no package selected yet
                if (this.markers.length === 0) {
                    this.map.setView([lat, lng], 14);
                }
            });
        }
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
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                </div>
                <div class="stat-title">Paradas Totales</div>
                <div class="stat-value text-primary">18</div>
                <div class="stat-desc">Ruta optimizada</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="stat-title">Distancia Total</div>
                <div class="stat-value text-success">65 km</div>
                <div class="stat-desc">42 km completados</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Tiempo Estimado</div>
                <div class="stat-value text-warning">8h 30m</div>
                <div class="stat-desc">5h 30m transcurridas</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Progreso</div>
                <div class="stat-value text-accent">67%</div>
                <div class="stat-desc">12 de 18 paradas</div>
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
                    <div class="absolute bottom-4 left-4 right-4 z-[1000] flex justify-between pointer-events-none">
                        <div class="pointer-events-auto">
                            @if($selectedEnvio)
                                <div
                                    class="bg-base-100/90 backdrop-blur p-3 rounded-lg shadow-lg border border-base-200 max-w-xs">
                                    <h3 class="font-bold text-sm">{{ $selectedEnvio->paquete->codigo }}</h3>
                                    <p class="text-xs opacity-70 truncate">
                                        {{ $selectedEnvio->paquete->direccion ?? 'Sin dirección' }}</p>
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
                            <div wire:click="selectEnvio({{ $envio->id }})"
                                class="flex items-start gap-3 p-3 rounded-lg cursor-pointer transition-all {{ $selectedEnvio && $selectedEnvio->id == $envio->id ? 'bg-primary/10 border border-primary' : 'bg-base-200 hover:bg-base-300' }}">

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
                                    <div class="font-semibold text-sm truncate">{{ $envio->paquete->codigo }}</div>
                                    <div class="text-xs text-base-content/70 truncate">{{ $envio->paquete->descripcion }}
                                    </div>
                                    <div class="text-xs text-base-content/60 mt-1">
                                        {{ $envio->paquete->direccion ?? 'Sin dirección' }}</div>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold text-lg">{{ $selectedEnvio->paquete->codigo }}</h3>
                        <p class="text-base-content/70">{{ $selectedEnvio->paquete->descripcion }}</p>

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

                        <div class="mt-6 flex flex-wrap gap-2">
                            <button wire:click="updateStatus({{ $selectedEnvio->id }}, 'entregado')"
                                class="btn btn-success btn-sm text-white" {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'entregado' ? 'disabled' : '' }}>
                                Marcar Entregado
                            </button>
                            <button wire:click="updateStatus({{ $selectedEnvio->id }}, 'no-entregado')"
                                class="btn btn-error btn-sm text-white" {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'no-entregado' ? 'disabled' : '' }}>
                                No Entregado
                            </button>
                            <button wire:click="updateStatus({{ $selectedEnvio->id }}, 'pendiente')"
                                class="btn btn-warning btn-sm text-white" {{ ($selectedEnvio->estadoEnvio->slug ?? '') == 'pendiente' ? 'disabled' : '' }}>
                                Pendiente
                            </button>
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
</div>