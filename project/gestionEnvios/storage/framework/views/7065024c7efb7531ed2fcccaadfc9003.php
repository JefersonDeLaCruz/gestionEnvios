<div class="p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Bienvenido, Repartidor</h1>
        <p class="text-base-content/70 mt-1">Resumen de tu jornada del día de hoy</p>
    </div>

    <!-- Alert - Ruta Activa -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeRoute): ?>
    <div class="alert alert-info mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h3 class="font-bold"><?php echo e($activeRoute['name']); ?> (<?php echo e($activeRoute['package_count']); ?> entregas pendientes)</h3>
            <div class="text-xs">Inicio: <?php echo e($activeRoute['start_time']); ?> | Estimado de finalización: <?php echo e($activeRoute['end_time']); ?></div>
        </div>
        <a href="<?php echo e(route('repartidor.route')); ?>" class="btn btn-sm btn-primary">Ver Ruta en Mapa</a>
    </div>
    <?php else: ?>
    <div class="alert alert-success mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <h3 class="font-bold">¡Todo listo!</h3>
            <div class="text-xs">No tienes entregas pendientes por ahora.</div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-6">
        
        <div class="stat">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Entregadas Hoy</div>
            <div class="stat-value text-success"><?php echo e($stats['completed_today']); ?></div>
            <div class="stat-desc">De <?php echo e($stats['total_assigned']); ?> totales</div>
        </div>

        
        <div class="stat">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Pendientes</div>
            <div class="stat-value text-warning"><?php echo e($stats['pending_today']); ?></div>
            <div class="stat-desc">Para completar hoy</div>
        </div>

        
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="stat-title">Progreso</div>
            <div class="stat-value text-primary"><?php echo e($stats['completion_rate']); ?>%</div>
            <div class="stat-desc">Tasa de completado</div>
        </div>

        
        <div class="stat">
            <div class="stat-figure text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Tiempo Activo</div>
            <div class="stat-value text-accent"><?php echo e(\Carbon\Carbon::now()->format('H:i')); ?></div>
            <div class="stat-desc">Hora actual</div>
        </div>
    </div>

    
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title">Progreso del Día</h2>
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <progress class="progress progress-success w-full h-4" value="<?php echo e($stats['completion_rate']); ?>" max="100"></progress>
                </div>
                <span class="font-bold text-lg"><?php echo e($stats['completion_rate']); ?>%</span>
            </div>
            <div class="text-sm text-base-content/70"><?php echo e($stats['completed_today']); ?> de <?php echo e($stats['total_assigned']); ?> paquetes entregados</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Próximas Entregas
                </h2>
                <div class="space-y-3 mt-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $upcomingDeliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $envio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                    $receptor = $envio->paquete->envioClientes->where('tipo_cliente', 'receptor')->first()?->cliente;
                    $badgeColor = $index == 0 ? 'badge-error' : ($index == 1 ? 'badge-warning' : 'badge-info');
                    ?>
                    <div class="flex items-start gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 cursor-pointer transition-all">
                        <div class="badge <?php echo e($badgeColor); ?> badge-lg"><?php echo e($index + 1); ?></div>
                        <div class="flex-1">
                            <div class="font-semibold">#<?php echo e($envio->paquete->codigo); ?> - <?php echo e($receptor?->nombre); ?> <?php echo e($receptor?->apellido); ?></div>
                            <div class="text-sm text-base-content/70"><?php echo e($receptor?->direccion); ?></div>
                            <div class="text-xs text-base-content/60 mt-1">
                                Estado: <span class="badge badge-xs"><?php echo e($envio->estadoEnvio->nombre); ?></span>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-circle btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-base-content/50">
                        <p>No hay entregas pendientes</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingDeliveries->count() > 0): ?>
                <div class="card-actions justify-end mt-4">
                    <a href="<?php echo e(route('repartidor.packages')); ?>" class="btn btn-primary btn-sm gap-2">
                        Ver Todas las Entregas
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $envio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                            $badgeClass = match($envio->estadoEnvio->slug ?? '') {
                            'entregado' => 'badge-success',
                            'cancelado' => 'badge-error',
                            'en-transito' => 'badge-info',
                            default => 'badge-warning'
                            };
                            ?>
                            <tr>
                                <td class="text-xs"><?php echo e($envio->updated_at->format('h:i A')); ?></td>
                                <td class="font-mono text-xs">#<?php echo e($envio->paquete->codigo); ?></td>
                                <td><span class="badge rounded-full <?php echo e($badgeClass); ?> badge-xs"><?php echo e($envio->estadoEnvio->nombre); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-base-content/50">
                                    No hay actividad registrada hoy
                                </td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentHistory->count() > 0): ?>
                <div class="text-sm text-base-content/70 mt-2 text-center">
                    Mostrando las últimas <?php echo e($recentHistory->count()); ?> entregas
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/gestionEnvios/resources/views/livewire/repartidor/dashboard.blade.php ENDPATH**/ ?>