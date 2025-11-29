<div class="p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Bienvenido, Repartidor</h1>
        <p class="text-base-content/70 mt-1">Resumen de tu jornada del día de hoy</p>
    </div>

    <!-- Alert - Ruta Activa -->
    <div class="alert alert-info mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h3 class="font-bold">Ruta Activa: Norte - Zona Residencial</h3>
            <div class="text-xs">Inicio: 08:00 AM | Estimado de finalización: 05:30 PM</div>
        </div>
        <button class="btn btn-sm btn-primary">Ver Ruta en Mapa</button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Entregas Completadas -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Entregadas Hoy</div>
                <div class="stat-value text-success">12</div>
                <div class="stat-desc">De 18 totales</div>
            </div>
        </div>

        <!-- Pendientes -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Pendientes</div>
                <div class="stat-value text-warning">6</div>
                <div class="stat-desc">Para completar hoy</div>
            </div>
        </div>

        <!-- Distancia Recorrida -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="stat-title">Distancia</div>
                <div class="stat-value text-primary">42 km</div>
                <div class="stat-desc">De ~65 km total</div>
            </div>
        </div>

        <!-- Tiempo en Ruta -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Tiempo Activo</div>
                <div class="stat-value text-accent">5h 30m</div>
                <div class="stat-desc">Desde las 08:00 AM</div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title">Progreso del Día</h2>
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <progress class="progress progress-success w-full h-4" value="67" max="100"></progress>
                </div>
                <span class="font-bold text-lg">67%</span>
            </div>
            <div class="text-sm text-base-content/70">12 de 18 paquetes entregados</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Próximas Entregas -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Próximas Entregas (Prioritarias)
                </h2>
                <div class="space-y-3 mt-4">
                    <!-- Entrega 1 -->
                    <div class="flex items-start gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 cursor-pointer transition-all">
                        <div class="badge badge-error badge-lg">1</div>
                        <div class="flex-1">
                            <div class="font-semibold">#PKG013 - Carlos Méndez</div>
                            <div class="text-sm text-base-content/70">Av. Principal #123, Col. Centro</div>
                            <div class="text-xs text-base-content/60 mt-1">Urgente - Antes de las 3:00 PM</div>
                        </div>
                        <button class="btn btn-sm btn-circle btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Entrega 2 -->
                    <div class="flex items-start gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 cursor-pointer transition-all">
                        <div class="badge badge-warning badge-lg">2</div>
                        <div class="flex-1">
                            <div class="font-semibold">#PKG014 - Ana Ruiz</div>
                            <div class="text-sm text-base-content/70">Calle Flores #456, Col. Norte</div>
                            <div class="text-xs text-base-content/60 mt-1">2.3 km de distancia</div>
                        </div>
                        <button class="btn btn-sm btn-circle btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Entrega 3 -->
                    <div class="flex items-start gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 cursor-pointer transition-all">
                        <div class="badge badge-info badge-lg">3</div>
                        <div class="flex-1">
                            <div class="font-semibold">#PKG015 - Luis Torres</div>
                            <div class="text-sm text-base-content/70">Blvd. Insurgentes #789</div>
                            <div class="text-xs text-base-content/60 mt-1">3.1 km de distancia</div>
                        </div>
                        <button class="btn btn-sm btn-circle btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card-actions justify-end mt-4">
                    <button class="btn btn-primary btn-sm gap-2">
                        Ver Todas las Entregas
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Resumen de Entregas -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Historial de Hoy</h2>
                <div class="overflow-x-auto">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Paquete</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-xs">02:45 PM</td>
                                <td class="font-mono text-xs">#PKG012</td>
                                <td><span class="badge rounded-full badge-success badge-xs">Entregado</span></td>
                            </tr>
                            <tr>
                                <td class="text-xs">02:15 PM</td>
                                <td class="font-mono text-xs">#PKG011</td>
                                <td><span class="badge rounded-full badge-success badge-xs">Entregado</span></td>
                            </tr>
                            <tr>
                                <td class="text-xs">01:50 PM</td>
                                <td class="font-mono text-xs">#PKG010</td>
                                <td><span class="badge rounded-full badge-success badge-xs">Entregado</span></td>
                            </tr>
                            <tr>
                                <td class="text-xs">01:30 PM</td>
                                <td class="font-mono text-xs">#PKG009</td>
                                <td><span class="badge rounded-full badge-error badge-xs">No Entregado</span></td>
                            </tr>
                            <tr>
                                <td class="text-xs">01:00 PM</td>
                                <td class="font-mono text-xs">#PKG008</td>
                                <td><span class="badge rounded-full badge-success badge-xs">Entregado</span></td>
                            </tr>
                            <tr>
                                <td class="text-xs">12:30 PM</td>
                                <td class="font-mono text-xs">#PKG007</td>
                                <td><span class="badge rounded-full badge-success badge-xs">Entregado</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-sm text-base-content/70 mt-2 text-center">
                    Mostrando las últimas 6 entregas
                </div>
            </div>
        </div>
    </div>
</div>
