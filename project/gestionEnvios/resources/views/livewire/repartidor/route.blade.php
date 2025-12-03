<div class="p-6">
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
        <!-- Map Placeholder -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Mapa de Ruta</h2>
                    <!-- Map Placeholder - Ready for Google Maps or similar integration -->
                    <div class="bg-base-200 rounded-lg h-96 flex items-center justify-center relative overflow-hidden">
                        <!-- Decorative map-like background -->
                        <div class="absolute inset-0 opacity-10">
                            <svg class="w-full h-full" viewBox="0 0 400 400">
                                <line x1="0" y1="100" x2="400" y2="100" stroke="currentColor" stroke-width="1" />
                                <line x1="0" y1="200" x2="400" y2="200" stroke="currentColor" stroke-width="1" />
                                <line x1="0" y1="300" x2="400" y2="300" stroke="currentColor" stroke-width="1" />
                                <line x1="100" y1="0" x2="100" y2="400" stroke="currentColor" stroke-width="1" />
                                <line x1="200" y1="0" x2="200" y2="400" stroke="currentColor" stroke-width="1" />
                                <line x1="300" y1="0" x2="300" y2="400" stroke="currentColor" stroke-width="1" />
                            </svg>
                        </div>
                        <div class="text-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-16 h-16 mx-auto mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                            </svg>
                            <p class="text-base-content/50 font-medium">Integración de Mapa</p>
                            <p class="text-sm text-base-content/40 mt-2">Google Maps / Mapbox / OpenStreetMap</p>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button class="btn btn-primary btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Iniciar Navegación
                        </button>
                        <button class="btn btn-ghost btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reoptimizar Ruta
                        </button>
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
                        <!-- Stop 1 - Completed -->
                        <div class="flex items-start gap-3 p-3 bg-success/10 rounded-lg border border-success/20">
                            <div class="badge badge-success badge-lg">✓</div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm truncate">#PKG001</div>
                                <div class="text-xs text-base-content/70 truncate">Juan Pérez</div>
                                <div class="text-xs text-base-content/60 mt-1">Calle 1 #123</div>
                                <div class="text-xs text-success mt-1">✓ Entregado 08:30 AM</div>
                            </div>
                        </div>

                        <!-- Stop 2 - In Progress -->
                        <div class="flex items-start gap-3 p-3 bg-warning/10 rounded-lg border-2 border-warning">
                            <div class="badge badge-warning badge-lg">→</div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm truncate">#PKG013</div>
                                <div class="text-xs text-base-content/70 truncate">Carlos Méndez</div>
                                <div class="text-xs text-base-content/60 mt-1">Av. Principal #456</div>
                                <div class="text-xs text-warning mt-1 font-semibold">→ Siguiente parada</div>
                            </div>
                        </div>

                        <!-- Stop 3 - Pending -->
                        <div
                            class="flex items-start gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 cursor-pointer transition-all">
                            <div class="badge badge-ghost badge-lg">3</div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm truncate">#PKG014</div>
                                <div class="text-xs text-base-content/70 truncate">Ana Ruiz</div>
                                <div class="text-xs text-base-content/60 mt-1">Calle Flores #789</div>
                                <div class="text-xs text-base-content/50 mt-1">2.3 km</div>
                            </div>
                        </div>

                        <!-- Stop 4 - Pending -->
                        <div
                            class="flex items-start gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 cursor-pointer transition-all">
                            <div class="badge badge-ghost badge-lg">4</div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm truncate">#PKG015</div>
                                <div class="text-xs text-base-content/70 truncate">Luis Torres</div>
                                <div class="text-xs text-base-content/60 mt-1">Blvd. Norte #321</div>
                                <div class="text-xs text-base-content/50 mt-1">3.1 km</div>
                            </div>
                        </div>

                        <!-- Stop 5 - Pending Priority -->
                        <div class="flex items-start gap-3 p-3 bg-error/10 rounded-lg border border-error/20">
                            <div class="badge badge-error badge-lg">!</div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm truncate">#PKG016</div>
                                <div class="text-xs text-base-content/70 truncate">María García</div>
                                <div class="text-xs text-base-content/60 mt-1">Col. Centro #654</div>
                                <div class="text-xs text-error mt-1 font-semibold">Urgente - Antes 3:00 PM</div>
                            </div>
                        </div>

                        <!-- More stops... -->
                        <div
                            class="flex items-start gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 cursor-pointer transition-all">
                            <div class="badge badge-ghost badge-lg">6</div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm truncate">#PKG017</div>
                                <div class="text-xs text-base-content/70 truncate">Roberto Sánchez</div>
                                <div class="text-xs text-base-content/60 mt-1">Av. Sur #987</div>
                                <div class="text-xs text-base-content/50 mt-1">4.5 km</div>
                            </div>
                        </div>

                        <div class="text-center py-2 text-sm text-base-content/50">
                            + 12 paradas más
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Route Timeline -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title mb-4">Línea de Tiempo de la Ruta</h2>
            <ul class="timeline timeline-vertical">
                <li>
                    <div class="timeline-start timeline-box bg-success/20 border-success">
                        <div class="font-bold text-sm">08:00 AM - Inicio</div>
                        <div class="text-xs">Centro de Distribución</div>
                    </div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 text-success">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <hr class="bg-success" />
                </li>
                <li>
                    <hr class="bg-success" />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 text-success">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end timeline-box bg-success/20 border-success">
                        <div class="font-bold text-sm">08:30 AM - Parada 1</div>
                        <div class="text-xs">#PKG001 - Juan Pérez ✓</div>
                    </div>
                    <hr class="bg-warning" />
                </li>
                <li>
                    <hr class="bg-warning" />
                    <div class="timeline-start timeline-box bg-warning/20 border-warning">
                        <div class="font-bold text-sm">02:45 PM - Actual</div>
                        <div class="text-xs">#PKG013 - Carlos Méndez</div>
                    </div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 text-warning">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <hr class="bg-base-300" />
                </li>
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
                    <div class="timeline-end timeline-box">
                        <div class="font-bold text-sm">~05:30 PM - Fin Estimado</div>
                        <div class="text-xs">Retorno al Centro</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>