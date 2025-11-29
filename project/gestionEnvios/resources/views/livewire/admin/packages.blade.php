<div class="p-6">
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Gestión de Paquetes</h1>
            <p class="text-base-content/70 mt-1">Administra todos los paquetes y envíos</p>
        </div>
        <button class="btn btn-primary gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nuevo Paquete
        </button>
    </div>

    <!-- Filters -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Buscar</span>
                    </label>
                    <input type="text" placeholder="Número de seguimiento, cliente..." class="input input-bordered" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Estado</span>
                    </label>
                    <select class="select select-bordered">
                        <option>Todos</option>
                        <option>Pendiente</option>
                        <option>En tránsito</option>
                        <option>Entregado</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Fecha</span>
                    </label>
                    <input type="date" class="input input-bordered" />
                </div>
            </div>
        </div>
    </div>

    <!-- Packages Table -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Seguimiento</th>
                            <th>Cliente</th>
                            <th>Destino</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-mono">#PKG001</td>
                            <td>Juan Pérez</td>
                            <td>Ciudad de México</td>
                            <td><span class="badge badge-warning">En tránsito</span></td>
                            <td>2025-11-28</td>
                            <td>
                                <button class="btn btn-ghost btn-xs">Ver</button>
                                <button class="btn btn-ghost btn-xs">Editar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-mono">#PKG002</td>
                            <td>María González</td>
                            <td>Guadalajara</td>
                            <td><span class="badge badge-success">Entregado</span></td>
                            <td>2025-11-27</td>
                            <td>
                                <button class="btn btn-ghost btn-xs">Ver</button>
                                <button class="btn btn-ghost btn-xs">Editar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-mono">#PKG003</td>
                            <td>Carlos Ramírez</td>
                            <td>Monterrey</td>
                            <td><span class="badge badge-info">Pendiente</span></td>
                            <td>2025-11-28</td>
                            <td>
                                <button class="btn btn-ghost btn-xs">Ver</button>
                                <button class="btn btn-ghost btn-xs">Editar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-mono">#PKG004</td>
                            <td>Ana López</td>
                            <td>Puebla</td>
                            <td><span class="badge badge-warning">En tránsito</span></td>
                            <td>2025-11-28</td>
                            <td>
                                <button class="btn btn-ghost btn-xs">Ver</button>
                                <button class="btn btn-ghost btn-xs">Editar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-mono">#PKG005</td>
                            <td>Roberto Sánchez</td>
                            <td>Cancún</td>
                            <td><span class="badge badge-success">Entregado</span></td>
                            <td>2025-11-26</td>
                            <td>
                                <button class="btn btn-ghost btn-xs">Ver</button>
                                <button class="btn btn-ghost btn-xs">Editar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center mt-4">
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
