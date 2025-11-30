<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Todos los Envíos</h1>
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
                                                        {{-- Placeholder for future details modal/view --}}
                                                        <button class="btn btn-ghost btn-xs">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                        </button>
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
</div>