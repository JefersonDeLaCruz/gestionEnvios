<div class="p-6">
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Reportes y Análisis</h1>
        <p class="text-base-content/70 mt-1">Supervisa el rendimiento de los repartidores y el estado de los envíos</p>
    </div>

    {{-- Filter Section --}}
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title mb-4">Filtros</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                {{-- Date From --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Fecha Desde</span>
                    </label>
                    <input type="date" wire:model.live="dateFrom" class="input input-bordered w-full" />
                </div>

                {{-- Date To --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Fecha Hasta</span>
                    </label>
                    <input type="date" wire:model.live="dateTo" class="input input-bordered w-full" />
                </div>

                {{-- Driver Filter --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Repartidor</span>
                    </label>
                    <select wire:model.live="selectedDriver" class="select select-bordered w-full">
                        <option value="">Todos los repartidores</option>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->nombre }} {{ $driver->apellido }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Estado</span>
                    </label>
                    <select wire:model.live="selectedStatus" class="select select-bordered w-full">
                        <option value="">Todos los estados</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Reset Button --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">&nbsp;</span>
                    </label>
                    <button wire:click="resetFilters" class="btn btn-outline w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Resetear
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- General Statistics --}}

    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Estadísticas Generales</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            {{-- Total Deliveries --}}
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Total Envíos</div>
                    <div class="stat-value text-primary">{{ $generalStats['total_deliveries'] }}</div>
                </div>
            </div>

            {{-- Completed Deliveries --}}
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Completados</div>
                    <div class="stat-value text-success">{{ $generalStats['completed_deliveries'] }}</div>
                </div>
            </div>

            {{-- Active Deliveries --}}
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">En Proceso</div>
                    <div class="stat-value text-warning">{{ $generalStats['active_deliveries'] }}</div>
                </div>
            </div>

            {{-- Completion Rate --}}
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Tasa Completado</div>
                    <div class="stat-value text-info">{{ $generalStats['completion_rate'] }}%</div>
                </div>
            </div>

            {{-- Total Revenue --}}
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Ingresos Totales</div>
                    <div class="stat-value text-accent">${{ $generalStats['total_revenue'] }}</div>
                </div>
            </div>


        </div>
    </div>

    {{-- Two Column Layout for Driver Performance and Status Distribution --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Driver Performance --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Top 10 Repartidores
                </h2>
                <div class="overflow-x-auto">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Envíos</th>
                                <th>Completados</th>
                                <th>Ingresos</th>
                                <th>Efectividad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($driverPerformance as $index => $driver)
                            <tr class="hover">
                                <td>
                                    @if($index == 0)
                                    <span class="badge badge-warning">🥇</span>
                                    @elseif($index == 1)
                                    <span class="badge badge-sm">🥈</span>
                                    @elseif($index == 2)
                                    <span class="badge badge-sm">🥉</span>
                                    @else
                                    {{ $index + 1 }}
                                    @endif
                                </td>
                                <td>
                                    <div class="font-semibold">{{ $driver->nombre }} {{ $driver->apellido }}</div>
                                    <div class="text-xs text-base-content/70">{{ $driver->email }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-primary badge-sm">{{ $driver->total_deliveries }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success badge-sm">{{ $driver->completed_deliveries }}</span>
                                </td>
                                <td class="font-mono text-sm">${{ number_format($driver->total_revenue ?? 0, 2) }}</td>
                                <td>
                                    @php
                                    $effectiveness = $driver->total_deliveries > 0
                                    ? round(($driver->completed_deliveries / $driver->total_deliveries) * 100)
                                    : 0;
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <progress class="progress progress-success w-16" value="{{ $effectiveness }}" max="100"></progress>
                                        <span class="text-xs">{{ $effectiveness }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-base-content/50">
                                    No hay datos disponibles en el rango seleccionado
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Status Distribution --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    Distribución por Estado
                </h2>
                <div class="space-y-4">
                    @php
                    $totalCount = $statusDistribution->sum('total');
                    @endphp
                    @forelse($statusDistribution as $status)
                    @php
                    $percentage = $totalCount > 0 ? round(($status->total / $totalCount) * 100, 1) : 0;
                    $colorClass = match($status->estadoEnvio->slug ?? '') {
                    'pendiente' => 'progress-warning',
                    'en-transito' => 'progress-info',
                    'entregado' => 'progress-success',
                    'cancelado' => 'progress-error',
                    default => 'progress-primary'
                    };
                    $badgeClass = match($status->estadoEnvio->slug ?? '') {
                    'pendiente' => 'badge-warning',
                    'en-transito' => 'badge-info',
                    'entregado' => 'badge-success',
                    'cancelado' => 'badge-error',
                    default => 'badge-primary'
                    };
                    @endphp
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <span class="badge {{ $badgeClass }} badge-sm">{{ $status->estadoEnvio->nombre ?? 'N/A' }}</span>
                                <span class="font-semibold">{{ $status->total }}</span>
                            </div>
                            <span class="text-sm text-base-content/70">{{ $percentage }}%</span>
                        </div>
                        <progress class="progress {{ $colorClass }} w-full" value="{{ $percentage }}" max="100"></progress>
                    </div>
                    @empty
                    <div class="text-center py-8 text-base-content/50">
                        No hay datos disponibles
                    </div>
                    @endforelse
                </div>

                @if($totalCount > 0)
                <div class="divider"></div>
                <div class="flex justify-between items-center">
                    <span class="font-bold">Total</span>
                    <span class="font-bold text-primary">{{ $totalCount }} envíos</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Detailed Deliveries List --}}
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Historial de Envíos
                </h2>
                <!-- <div class="flex gap-2">
                    <button class="btn btn-sm btn-outline gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Exportar Excel
                    </button>
                    <button class="btn btn-sm btn-outline gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Imprimir PDF
                    </button>
                </div> -->
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>ID Envío</th>
                            <th>Paquete</th>
                            <th>Repartidor</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Costo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deliveries as $delivery)
                        <tr class="hover">
                            <td class="font-mono text-sm">#{{ $delivery->paquete->codigo }}</td>
                            <td>
                                <div class="font-semibold">{{ $delivery->paquete->descripcion ?? 'N/A' }}</div>
                                <div class="text-xs text-base-content/70">Peso: {{ $delivery->paquete->peso ?? 'N/A' }} kg</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral text-neutral-content rounded-full w-8">
                                            <span class="text-xs">{{ substr($delivery->motorista->nombre ?? 'N', 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-sm">{{ $delivery->motorista->nombre ?? 'N/A' }} {{ $delivery->motorista->apellido ?? '' }}</div>
                                        <div class="text-xs text-base-content/70">{{ $delivery->motorista->telefono ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                $badgeClass = match($delivery->estadoEnvio->slug ?? '') {
                                'pendiente' => 'badge-warning',
                                'en-transito' => 'badge-info',
                                'entregado' => 'badge-success',
                                'cancelado' => 'badge-error',
                                default => 'badge-primary'
                                };
                                @endphp
                                <span class="badge {{ $badgeClass }} rounded-full">{{ $delivery->estadoEnvio->nombre ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="text-sm">{{ \Carbon\Carbon::parse($delivery->fecha_estimada)->format('d/m/Y') }}</div>
                            </td>
                            <td class="font-mono font-semibold text-success">${{ number_format($delivery->costo, 2) }}</td>
                            <td>
                                <button wire:click="viewHistory({{ $delivery->id }})" class="btn btn-sm btn-ghost btn-circle" title="Ver Historial">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-12">
                                <div class="flex flex-col items-center gap-2 text-base-content/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="font-semibold">No se encontraron envíos</p>
                                    <p class="text-sm">Intenta ajustar los filtros para ver más resultados</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{-- @if($deliveries->hasPages())
                <div class="mt-4">
                    {{ $deliveries->links() }}
        </div>
        @endif --}}
    </div>

    {{-- History Modal --}}
    @if($showHistoryModal)
    <div class="modal modal-open">
        <div class="modal-box relative max-w-2xl">
            <button wire:click="closeHistoryModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</button>
            <h3 class="text-lg font-bold mb-4">Historial del Envío</h3>

            <div class="overflow-y-auto max-h-[60vh]">
                <ul class="steps steps-vertical w-full">
                    @forelse($history as $record)
                    <li class="step step-primary">
                        <div class="text-left w-full ml-4 mb-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold">{{ $record->estadoEnvio->nombre ?? 'Estado Desconocido' }}</span>
                                <span class="text-xs text-base-content/60">{{ \Carbon\Carbon::parse($record->created_at)->format('d/m/Y h:i A') }}</span>
                            </div>

                            @if($record->comentario)
                            <p class="text-sm text-base-content/80 mb-2">{{ $record->comentario }}</p>
                            @endif

                            @if($record->foto_url)
                            <div class="mt-2">
                                <button wire:click="viewImage('{{ $record->foto_url }}')" class="btn btn-xs btn-outline btn-primary gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Ver Evidencia
                                </button>
                            </div>
                            @endif
                        </div>
                    </li>
                    @empty
                    <li class="step step-neutral">
                        <div class="text-left w-full ml-4">
                            <span class="font-bold">Sin historial registrado</span>
                        </div>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="modal-backdrop" wire:click="closeHistoryModal"></div>
    </div>
</div>
@endif

{{-- Image Preview Modal --}}
@if($showImageModal)
<div class="modal modal-open" style="z-index: 9999;">
    <div class="modal-box relative max-w-4xl flex justify-center items-center bg-transparent shadow-none">
        <button wire:click="closeImageModal" class="btn btn-circle btn-sm absolute right-2 top-2 bg-base-100 border-none text-base-content hover:bg-base-200 z-50">✕</button>
        <img src="{{ asset('storage/' . $selectedImageUrl) }}" alt="Evidencia Grande" class="max-h-[85vh] rounded-lg shadow-2xl object-contain bg-base-100">
    </div>
    <div class="modal-backdrop bg-black/80" wire:click="closeImageModal"></div>
</div>
@endif
</div>
</div>