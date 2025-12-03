<div class="p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Historial de Entregas</h1>
        <p class="text-base-content/70 mt-1">Seguimiento de tu rendimiento y entregas pasadas</p>
    </div>

    <!-- Date Filter Tabs -->
    <div class="tabs tabs-boxed mb-6 bg-base-200">
        <a class="tab tab-active">Hoy</a>
        <a class="tab">Esta Semana</a>
        <a class="tab">Este Mes</a>
        <a class="tab">Personalizado</a>
    </div>

    <!-- Performance Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Total Entregas</div>
                <div class="stat-value text-success">156</div>
                <div class="stat-desc">Este mes</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="stat-title">Tasa de Éxito</div>
                <div class="stat-value text-primary">94%</div>
                <div class="stat-desc">↗︎ +2% vs mes pasado</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Tiempo Promedio</div>
                <div class="stat-value text-accent">8.2 min</div>
                <div class="stat-desc">Por entrega</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="stat-title">Distancia Total</div>
                <div class="stat-value text-warning">1,245 km</div>
                <div class="stat-desc">Este mes</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Performance Chart Placeholder -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Rendimiento Semanal</h2>
                    <!-- Chart Placeholder -->
                    <div class="bg-base-200 rounded-lg h-64 flex items-center justify-center">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-16 h-16 mx-auto mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                            <p class="text-base-content/50 font-medium">Gráfico de Rendimiento</p>
                            <p class="text-sm text-base-content/40 mt-2">Chart.js / ApexCharts</p>
                        </div>
                    </div>

                    <!-- Weekly Stats -->
                    <div class="grid grid-cols-7 gap-2 mt-4">
                        <div class="text-center">
                            <div class="text-xs text-base-content/60 mb-1">Lun</div>
                            <div class="bg-success h-12 rounded flex items-end justify-center pb-1">
                                <span class="text-xs font-bold text-success-content">24</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-base-content/60 mb-1">Mar</div>
                            <div class="bg-success h-16 rounded flex items-end justify-center pb-1">
                                <span class="text-xs font-bold text-success-content">28</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-base-content/60 mb-1">Mié</div>
                            <div class="bg-success h-14 rounded flex items-end justify-center pb-1">
                                <span class="text-xs font-bold text-success-content">26</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-base-content/60 mb-1">Jue</div>
                            <div class="bg-success h-20 rounded flex items-end justify-center pb-1">
                                <span class="text-xs font-bold text-success-content">32</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-base-content/60 mb-1">Vie</div>
                            <div class="bg-success h-18 rounded flex items-end justify-center pb-1">
                                <span class="text-xs font-bold text-success-content">30</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-base-content/60 mb-1">Sáb</div>
                            <div class="bg-warning h-10 rounded flex items-end justify-center pb-1">
                                <span class="text-xs font-bold text-warning-content">18</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-base-content/60 mb-1">Dom</div>
                            <div class="bg-base-300 h-8 rounded flex items-end justify-center pb-1">
                                <span class="text-xs font-bold">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-lg">Estadísticas Rápidas</h2>

                    <div class="space-y-4 mt-4">
                        <!-- Success Rate -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Entregas Exitosas</span>
                                <span class="font-bold">94%</span>
                            </div>
                            <progress class="progress progress-success w-full" value="94" max="100"></progress>
                        </div>

                        <!-- On Time Rate -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Entregas a Tiempo</span>
                                <span class="font-bold">87%</span>
                            </div>
                            <progress class="progress progress-primary w-full" value="87" max="100"></progress>
                        </div>

                        <!-- Customer Satisfaction -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Satisfacción Cliente</span>
                                <span class="font-bold">4.8/5</span>
                            </div>
                            <progress class="progress progress-accent w-full" value="96" max="100"></progress>
                        </div>

                        <!-- Failed Deliveries -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Entregas Fallidas</span>
                                <span class="font-bold">6%</span>
                            </div>
                            <progress class="progress progress-error w-full" value="6" max="100"></progress>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Achievements -->
                    <div>
                        <h3 class="font-semibold mb-3">Logros Recientes</h3>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 p-2 bg-warning/10 rounded-lg">
                                <div class="text-2xl">🏆</div>
                                <div class="text-xs">
                                    <div class="font-semibold">Top Performer</div>
                                    <div class="text-base-content/60">Esta semana</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 p-2 bg-success/10 rounded-lg">
                                <div class="text-2xl">⭐</div>
                                <div class="text-xs">
                                    <div class="font-semibold">100% Éxito</div>
                                    <div class="text-base-content/60">Ayer</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 p-2 bg-primary/10 rounded-lg">
                                <div class="text-2xl">🚀</div>
                                <div class="text-xs">
                                    <div class="font-semibold">Récord Personal</div>
                                    <div class="text-base-content/60">32 entregas/día</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery History Table -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Historial Detallado</h2>
                <button class="btn btn-sm btn-ghost gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Exportar
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Tracking</th>
                            <th>Cliente</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Tiempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-xs">
                                <div>28/11/2025</div>
                                <div class="text-base-content/60">02:45 PM</div>
                            </td>
                            <td class="font-mono text-xs font-bold">#PKG012</td>
                            <td>
                                <div class="font-semibold text-sm">Pedro Sánchez</div>
                                <div class="text-xs text-base-content/60">+52 555-9012</div>
                            </td>
                            <td class="text-sm">Blvd. Sur #789</td>
                            <td><span class="badge rounded-full badge-success badge-sm">Entregado</span></td>
                            <td class="text-xs">7 min</td>
                        </tr>
                        <tr>
                            <td class="text-xs">
                                <div>28/11/2025</div>
                                <div class="text-base-content/60">02:15 PM</div>
                            </td>
                            <td class="font-mono text-xs font-bold">#PKG011</td>
                            <td>
                                <div class="font-semibold text-sm">María López</div>
                                <div class="text-xs text-base-content/60">+52 555-3456</div>
                            </td>
                            <td class="text-sm">Calle 3 #456</td>
                            <td><span class="badge rounded-full badge-success badge-sm">Entregado</span></td>
                            <td class="text-xs">9 min</td>
                        </tr>
                        <tr>
                            <td class="text-xs">
                                <div>28/11/2025</div>
                                <div class="text-base-content/60">01:50 PM</div>
                            </td>
                            <td class="font-mono text-xs font-bold">#PKG010</td>
                            <td>
                                <div class="font-semibold text-sm">Jorge Ramírez</div>
                                <div class="text-xs text-base-content/60">+52 555-7890</div>
                            </td>
                            <td class="text-sm">Av. Central #123</td>
                            <td><span class="badge rounded-full badge-success badge-sm">Entregado</span></td>
                            <td class="text-xs">6 min</td>
                        </tr>
                        <tr class="bg-error/5">
                            <td class="text-xs">
                                <div>28/11/2025</div>
                                <div class="text-base-content/60">01:30 PM</div>
                            </td>
                            <td class="font-mono text-xs font-bold">#PKG009</td>
                            <td>
                                <div class="font-semibold text-sm">Laura Martínez</div>
                                <div class="text-xs text-base-content/60">+52 555-3456</div>
                            </td>
                            <td class="text-sm">Calle 5 #321</td>
                            <td><span class="badge rounded-full badge-error badge-sm">No entregado</span></td>
                            <td class="text-xs">12 min</td>
                        </tr>
                        <tr>
                            <td class="text-xs">
                                <div>28/11/2025</div>
                                <div class="text-base-content/60">01:00 PM</div>
                            </td>
                            <td class="font-mono text-xs font-bold">#PKG008</td>
                            <td>
                                <div class="font-semibold text-sm">Carlos Díaz</div>
                                <div class="text-xs text-base-content/60">+52 555-1234</div>
                            </td>
                            <td class="text-sm">Col. Norte #654</td>
                            <td><span class="badge rounded-full badge-success badge-sm">Entregado</span></td>
                            <td class="text-xs">8 min</td>
                        </tr>
                        <tr>
                            <td class="text-xs">
                                <div>28/11/2025</div>
                                <div class="text-base-content/60">12:30 PM</div>
                            </td>
                            <td class="font-mono text-xs font-bold">#PKG007</td>
                            <td>
                                <div class="font-semibold text-sm">Ana Torres</div>
                                <div class="text-xs text-base-content/60">+52 555-5678</div>
                            </td>
                            <td class="text-sm">Blvd. Este #987</td>
                            <td><span class="badge rounded-full badge-success badge-sm">Entregado</span></td>
                            <td class="text-xs">10 min</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-6">
                <div class="join">
                    <button class="join-item btn btn-sm">«</button>
                    <button class="join-item btn btn-sm btn-active">1</button>
                    <button class="join-item btn btn-sm">2</button>
                    <button class="join-item btn btn-sm">3</button>
                    <button class="join-item btn btn-sm">»</button>
                </div>
            </div>
        </div>
    </div>
</div>