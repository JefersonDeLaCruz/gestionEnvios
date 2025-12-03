<div class="p-6">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold">Historial de Paquetes</h1>
            <p class="text-base-content/70 mt-1">Historial completo de todos tus paquetes asignados</p>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                    </svg>
                </div>
                <div class="stat-title">Total Asignados</div>
                <div class="stat-value text-primary">{{ $stats['total'] }}</div>
                <div class="stat-desc">Para hoy</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Entregados</div>
                <div class="stat-value text-success">{{ $stats['entregados'] }}</div>
                <div class="stat-desc">Completados</div>
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
                <div class="stat-title">Pendientes</div>
                <div class="stat-value text-warning">{{ $stats['pendientes'] }}</div>
                <div class="stat-desc">Por entregar</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Enviados</div>
                <div class="stat-value text-info">{{ $stats['enviados'] }}</div>
                <div class="stat-desc">En ruta</div>
            </div>
        </div>
    </div>

    <!-- Packages Table -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title mb-4">Todos los Paquetes</h2>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Tracking</th>
                            <th>Paquete</th>
                            <th>prioridad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($envios as $envio)
                            @php
                                // Normalizar nombre del estado y evitar null
                                $estado_norm = strtolower(trim($envio->estadoEnvio->nombre ?? ''));
                            @endphp



                            <tr class="hover">
                                <td class="font-mono font-bold">#{{ $envio->paquete->codigo }}</td>

                                <td>
                                    <div class="font-semibold">{{ $envio->paquete->descripcion }}</div>
                                    <div class="text-xs text-base-content/60">
                                        {{ $envio->paquete->peso }}kg - {{ $envio->paquete->dimensiones }}
                                    </div>
                                </td>

                                <td>
                                    <div class="text-sm">
                                        {{ $envio->paquete->tipoEnvio->nombre }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge badge-ghost">
                                        {{ $envio->estadoEnvio->nombre ?? 'Desconocido' }}
                                    </span>
                                </td>

                                <td>
                                    <button wire:click="openModal({{ $envio->id }})" class="btn btn-primary btn-xs">
                                        Actualizar Estado
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No tienes paquetes asignados para hoy.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    @if($showModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Actualizar Estado del Envío #{{ $selectedEnvio->paquete->codigo }}</h3>

                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text">Nuevo Estado</span>
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($estados as $estado)
                            <button wire:click="$set('newStatusId', {{ $estado->id }})"
                                class="btn {{ $newStatusId == $estado->id ? 'btn-primary' : 'btn-outline' }} btn-sm">
                                {{ $estado->nombre }}
                            </button>
                        @endforeach
                    </div>
                    @error('newStatusId') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text">Comentario</span>
                    </label>
                    <textarea wire:model="comment" class="textarea textarea-bordered h-24"
                        placeholder="Añadir un comentario..."></textarea>
                    @error('comment') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Show photo input if status is 'entregado' (checking by ID or name in loop, but here we need to know which one is selected) -->
                <!-- Using a helper property or checking the selected status in the list -->
                @php
                    $selectedStatus = $estados->find($newStatusId);
                @endphp

                @if($selectedStatus && $selectedStatus->slug === 'entregado')
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
                    <button wire:click="updateStatus" class="btn btn-primary" wire:loading.attr="disabled">Guardar</button>
                </div>
            </div>
        </div>
    @endif
</div>