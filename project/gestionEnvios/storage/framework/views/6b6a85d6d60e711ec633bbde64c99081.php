<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Todos los Envíos</h1>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status->id); ?>"><?php echo e($status->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
            </div>

            
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Remitente / Destinatario</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha Estimada</th>
                            <th>Repartidor</th>
                            <th>Costo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td class="font-bold font-mono"><?php echo e($shipment->paquete->codigo); ?></td>
                                                    <td>
                                                        <div class="flex flex-col text-sm">
                                                            <?php
                                                                $remitente = $shipment->paquete->envioClientes->where('tipo_cliente', 'emisor')->first()?->cliente;
                                                                $destinatario = $shipment->paquete->envioClientes->where('tipo_cliente', 'receptor')->first()?->cliente;
                                                            ?>
                                                            <span class="font-semibold">De:
                                                                <?php echo e($remitente ? $remitente->nombre . ' ' . $remitente->apellido : 'N/A'); ?></span>
                                                            <span class="text-base-content/70">Para:
                                                                <?php echo e($destinatario ? $destinatario->nombre . ' ' . $destinatario->apellido : 'N/A'); ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php echo e($shipment->paquete->tipoEnvio->nombre); ?>

                                                    </td>
                                                    <td>
                                                        <div class="badge <?php echo e(match ($shipment->estadoEnvio->slug ?? '') {
                                'pendiente' => 'badge-warning',
                                'en-transito' => 'badge-info',
                                'entregado' => 'badge-success',
                                'cancelado' => 'badge-error',
                                default => 'badge-ghost'
                            }); ?> gap-2">
                                                            <?php echo e($shipment->estadoEnvio->nombre ?? 'Desconocido'); ?>

                                                        </div>
                                                    </td>
                                                    <td><?php echo e($shipment->fecha_estimada ? \Carbon\Carbon::parse($shipment->fecha_estimada)->format('d/m/Y') : 'N/A'); ?>

                                                    </td>
                                                    <td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($shipment->motorista): ?>
                                                            <div class="flex items-center gap-2">
                                                                <div class="avatar placeholder">
                                                                    <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                                                        <span
                                                                            class="text-xs"><?php echo e(substr($shipment->motorista->nombre, 0, 1)); ?><?php echo e(substr($shipment->motorista->apellido, 0, 1)); ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex flex-col">
                                                                    <span class="font-bold text-xs"><?php echo e($shipment->motorista->nombre); ?>

                                                                        <?php echo e($shipment->motorista->apellido); ?></span>
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($shipment->vehiculo): ?>
                                                                        <span
                                                                            class="text-[10px] opacity-70"><?php echo e($shipment->vehiculo->numero_placas); ?></span>
                                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-base-content/50 italic text-sm">Sin asignar</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="font-mono">$<?php echo e(number_format($shipment->costo, 2)); ?></td>
                                                    <td>
                                                        <button wire:click="openDetailsModal(<?php echo e($shipment->id); ?>)" class="btn btn-ghost btn-xs">
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="mt-4">
                <?php echo e($shipments->links()); ?>

            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDetailsModal && $selectedShipment): ?>
        <div class="modal modal-open">
            <div class="modal-box w-11/12 max-w-4xl border border-base-300">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="font-bold text-2xl flex items-center gap-3">
                            Envío #<?php echo e($selectedShipment->paquete->codigo); ?>

                            <div class="badge <?php echo e(match ($selectedShipment->estadoEnvio->slug ?? '') {
            'pendiente' => 'badge-warning',
            'en-transito' => 'badge-info',
            'entregado' => 'badge-success',
            'cancelado' => 'badge-error',
            default => 'badge-ghost'
        }); ?> badge-lg">
                                <?php echo e($selectedShipment->estadoEnvio->nombre ?? 'Desconocido'); ?>

                            </div>
                        </h3>
                        <p class="text-base-content/60 text-sm mt-1">
                            Creado el <?php echo e($selectedShipment->created_at->format('d/m/Y H:i')); ?>

                        </p>
                    </div>
                    <button wire:click="closeDetailsModal" class="btn btn-circle btn-ghost btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="card bg-base-200">
                        <div class="card-body p-4">
                            <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Información del Paquete</h4>
                            <div class="space-y-2">
                                <p><span class="font-semibold">Descripción:</span>
                                    <?php echo e($selectedShipment->paquete->descripcion); ?></p>
                                <div class="flex gap-4">
                                    <p><span class="font-semibold">Peso:</span> <?php echo e($selectedShipment->paquete->peso); ?> lb
                                    </p>
                                    <p><span class="font-semibold">Dimensiones:</span>
                                        <?php echo e($selectedShipment->paquete->dimensiones ?? 'N/A'); ?></p>
                                </div>
                                <p><span class="font-semibold">Tipo de Envío:</span> <span
                                        class="badge badge-outline capitalize"><?php echo e($selectedShipment->paquete->tipoEnvio->nombre); ?></span>
                                </p>
                                <p><span class="font-semibold">Costo:</span>
                                    $<?php echo e(number_format($selectedShipment->costo, 2)); ?></p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card bg-base-200">
                        <div class="card-body p-4">
                            <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Logística</h4>
                            <div class="space-y-2">
                                <p><span class="font-semibold">Fecha Estimada:</span>
                                    <?php echo e(\Carbon\Carbon::parse($selectedShipment->fecha_estimada)->format('d/m/Y')); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedShipment->motorista): ?>
                                    <div class="flex items-center gap-3 mt-2">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-10">
                                                <span><?php echo e(substr($selectedShipment->motorista->nombre, 0, 1)); ?></span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-bold"><?php echo e($selectedShipment->motorista->nombre); ?>

                                                <?php echo e($selectedShipment->motorista->apellido); ?></p>
                                            <p class="text-xs opacity-70">Repartidor</p>
                                        </div>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedShipment->vehiculo): ?>
                                        <p class="text-sm mt-2"><span class="font-semibold">Vehículo:</span>
                                            <?php echo e($selectedShipment->vehiculo->marca); ?> <?php echo e($selectedShipment->vehiculo->modelo); ?>

                                            (<?php echo e($selectedShipment->vehiculo->numero_placas); ?>)</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-warning py-2 text-sm mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span>Sin repartidor asignado</span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <?php
                        $remitente = $selectedShipment->paquete->envioClientes->where('tipo_cliente', 'emisor')->first()?->cliente;
                    ?>
                    <div class="card border border-base-300">
                        <div class="card-body p-4">
                            <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Remitente (Origen)</h4>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($remitente): ?>
                                <p class="font-bold text-lg"><?php echo e($remitente->nombre); ?> <?php echo e($remitente->apellido); ?></p>
                                <p class="text-sm flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-1 opacity-70" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <?php echo e($remitente->direccion); ?>

                                </p>
                                <div class="divider my-1"></div>
                                <p class="text-sm"><span class="opacity-70">Tel:</span> <?php echo e($remitente->telefono); ?></p>
                                <p class="text-sm"><span class="opacity-70">Email:</span> <?php echo e($remitente->email); ?></p>
                            <?php else: ?>
                                <p class="italic opacity-50">Información no disponible</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <?php
                        $destinatario = $selectedShipment->paquete->envioClientes->where('tipo_cliente', 'receptor')->first()?->cliente;
                    ?>
                    <div class="card border border-base-300">
                        <div class="card-body p-4">
                            <h4 class="card-title text-sm uppercase text-base-content/50 mb-2">Destinatario (Destino)</h4>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($destinatario): ?>
                                <p class="font-bold text-lg"><?php echo e($destinatario->nombre); ?> <?php echo e($destinatario->apellido); ?></p>
                                <p class="text-sm flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-1 opacity-70" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <?php echo e($destinatario->direccion); ?>

                                </p>
                                <div class="divider my-1"></div>
                                <p class="text-sm"><span class="opacity-70">Tel:</span> <?php echo e($destinatario->telefono); ?></p>
                                <p class="text-sm"><span class="opacity-70">Email:</span> <?php echo e($destinatario->email); ?></p>
                            <?php else: ?>
                                <p class="italic opacity-50">Información no disponible</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="modal-action">
                    <button wire:click="closeDetailsModal" class="btn">Cerrar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH /var/www/html/gestionEnvios/resources/views/livewire/admin/all-shipments.blade.php ENDPATH**/ ?>