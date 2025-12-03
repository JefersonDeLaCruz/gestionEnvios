<div class="p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-base-content/70 mt-1">Bienvenido al panel de administración</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                </div>
                <div class="stat-title">Total Paquetes</div>
                <div class="stat-value text-primary">{{ $totalPaquetes }}</div>
                <div class="stat-desc">Registrados en el sistema</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="stat-title">Usuarios Activos</div>
                <div class="stat-value text-secondary">{{ $usuariosActivos }}</div>
                <div class="stat-desc">Usuarios registrados</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    </svg>
                </div>
                <div class="stat-title">Vehículos</div>
                <div class="stat-value text-accent">{{ $vehiculos }}</div>
                <div class="stat-desc">Flota total</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div class="stat-title">Ingresos Hoy</div>
                <div class="stat-value text-success">${{ number_format($ingresosHoy, 2) }}</div>
                <div class="stat-desc">Calculado de envíos de hoy</div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            z-index: 1;
        }
    </style>
    @endpush

    <!-- Map Section -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title">Mapa de Entregas Estimadas para Hoy</h2>
            <div id="map" class="rounded-lg"></div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('livewire:navigated', function() {
            initMap();
        });

        // Also init on first load if not using livewire navigation or for initial page load
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });

        function initMap() {
            // Check if map container exists
            if (!document.getElementById('map')) return;

            // Check if map is already initialized
            var container = L.DomUtil.get('map');
            if (container != null) {
                container._leaflet_id = null;
            }

            var map = L.map('map').setView([13.6929, -89.2182], 13); // San Salvador default

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var paquetes = @json($paquetesDelDia);
            var bounds = [];

            paquetes.forEach(function(paquete) {
                if (paquete.latitud && paquete.longitud) {
                    var marker = L.marker([paquete.latitud, paquete.longitud]).addTo(map);
                    marker.bindPopup(`
                        <b>${paquete.codigo}</b><br>
                        ${paquete.descripcion || 'Sin descripción'}
                    `);
                    bounds.push([paquete.latitud, paquete.longitud]);
                }
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds);
            }
        }
    </script>
    @endpush

    <!-- Recent Activity -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Actividad Reciente</h2>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivity as $activity)
                        <tr>
                            <td>{{ $activity->envio->paquete->codigo ?? 'N/A' }}</td>
                            <td>{{ $activity->comentario ?? 'Sin descripción' }}</td>
                            <td>
                                <span class="badge rounded-full badge-primary">
                                    {{ $activity->estadoEnvio->nombre ?? 'Desconocido' }}
                                </span>
                            </td>
                            <td>{{ $activity->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay actividad reciente</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>