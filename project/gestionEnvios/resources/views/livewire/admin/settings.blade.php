<div class="p-6">
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Configuración del Sistema</h1>
        <p class="text-base-content/70 mt-1">Gestiona los estados de envío, tarifas y tipos de vehículos</p>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success mb-6 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Tabs Navigation --}}
    <div class="tabs tabs-boxed mb-6 bg-base-200 p-2">
        <button wire:click="$set('activeTab', 'estados')" class="tab gap-2 {{ $activeTab === 'estados' ? 'tab-active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Estados de Envío
        </button>
        <button wire:click="$set('activeTab', 'tarifas')" class="tab gap-2 {{ $activeTab === 'tarifas' ? 'tab-active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tarifas
        </button>
        <button wire:click="$set('activeTab', 'vehiculos')" class="tab gap-2 {{ $activeTab === 'vehiculos' ? 'tab-active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
            </svg>
            Tipos de Vehículos
        </button>
    </div>

    {{-- TAB: Estados de Envío --}}
    @if($activeTab === 'estados')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">Estados de Envío</h2>
                    <button wire:click="openCreateEstadoModal" class="btn btn-primary btn-sm gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo Estado
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Slug</th>
                                <th>Estado Final</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($estados as $estado)
                                <tr class="hover">
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="badge badge-lg {{ $estado->slug === 'pendiente' ? 'badge-warning' : ($estado->slug === 'en-transito' ? 'badge-info' : ($estado->slug === 'entregado' ? 'badge-success' : 'badge-primary')) }}">
                                                {{ $estado->nombre }}
                                            </div>
                                        </div>
                                    </td>
                                    <td><code class="text-sm">{{ $estado->slug }}</code></td>
                                    <td>
                                        @if($estado->es_final)
                                            <span class="badge badge-success gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Sí
                                            </span>
                                        @else
                                            <span class="badge badge-ghost">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <button wire:click="openEditEstadoModal({{ $estado->id }})" class="btn btn-ghost btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button wire:click="confirmDeleteEstado({{ $estado->id }})" class="btn btn-ghost btn-sm text-error">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-base-content/50">No hay estados configurados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- TAB: Tarifas --}}
    @if($activeTab === 'tarifas')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">Tarifas</h2>
                    <button wire:click="openCreateTarifaModal" class="btn btn-primary btn-sm gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nueva Tarifa
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($tarifas as $tarifa)
                        <div class="card bg-base-200 shadow">
                            <div class="card-body">
                                <div class="flex justify-between items-start">
                                    <h3 class="card-title text-lg">{{ $tarifa->concepto }}</h3>
                                    <div class="dropdown dropdown-end">
                                        <label tabindex="0" class="btn btn-ghost btn-sm btn-circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </label>
                                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li><a wire:click="openEditTarifaModal({{ $tarifa->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Editar
                                            </a></li>
                                            <li><a wire:click="toggleTarifaActivo({{ $tarifa->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
                                                </svg>
                                                {{ $tarifa->activo ? 'Desactivar' : 'Activar' }}
                                            </a></li>
                                            <li><a wire:click="confirmDeleteTarifa({{ $tarifa->id }})" class="text-error">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Eliminar
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-base-content/70">Valor:</span>
                                        <span class="text-xl font-bold text-primary">${{ number_format($tarifa->valor, 2) }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-base-content/70">Tipo:</span>
                                        <span class="badge badge-outline">
                                            {{ $tarifa->tipo === 'fijo' ? 'Fijo' : ($tarifa->tipo === 'por_km' ? 'Por Km' : 'Por Kg') }}
                                        </span>
                                    </div>

                                    @if($tarifa->descripcion)
                                        <p class="text-sm text-base-content/70 mt-2">{{ $tarifa->descripcion }}</p>
                                    @endif

                                    <div class="flex justify-between items-center mt-4">
                                        <span class="text-sm text-base-content/70">Estado:</span>
                                        <span class="badge {{ $tarifa->activo ? 'badge-success' : 'badge-error' }} gap-1">
                                            @if($tarifa->activo)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Activa
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Inactiva
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-base-content/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-semibold text-lg">No hay tarifas configuradas</p>
                            <p class="text-sm">Comienza creando una nueva tarifa</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    {{-- TAB: Tipos de Vehículos --}}
    @if($activeTab === 'vehiculos')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">Tipos de Vehículos</h2>
                    <button wire:click="openCreateTipoVehiculoModal" class="btn btn-primary btn-sm gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo Tipo
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($tipoVehiculos as $tipo)
                        <div class="card bg-base-200 shadow">
                            <div class="card-body">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="card-title text-lg">{{ $tipo->nombre }}</h3>
                                        
                                    </div>
                                    
                                </div>

                                

                                <div class="card-actions justify-end mt-4">
                                   
                                    <button wire:click="openEditTipoVehiculoModal({{ $tipo->id }})" class="btn btn-ghost btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDeleteTipoVehiculo({{ $tipo->id }})" class="btn btn-ghost btn-sm text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-base-content/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            <p class="font-semibold text-lg">No hay tipos de vehículos configurados</p>
                            <p class="text-sm">Comienza creando un nuevo tipo de vehículo</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL: Estado de Envío --}}
    @if($showEstadoModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">{{ $editEstadoMode ? 'Editar Estado' : 'Nuevo Estado' }}</h3>
                
                <form wire:submit.prevent="saveEstado">
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Nombre <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model.live="estadoNombre" class="input input-bordered @error('estadoNombre') input-error @enderror" placeholder="En Tránsito" />
                        @error('estadoNombre')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Slug <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="estadoSlug" class="input input-bordered @error('estadoSlug') input-error @enderror" placeholder="en-transito" />
                        @error('estadoSlug')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                        <label class="label">
                            <span class="label-text-alt">Se usa en URLs y código</span>
                        </label>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label cursor-pointer justify-start gap-4">
                            <input type="checkbox" wire:model="estadoEsFinal" class="checkbox checkbox-primary" />
                            <span class="label-text">¿Es un estado final?</span>
                        </label>
                        <label class="label">
                            <span class="label-text-alt">Marca si el envío termina en este estado (ej: Entregado, Cancelado)</span>
                        </label>
                    </div>

                    <div class="modal-action">
                        <button type="button" wire:click="closeEstadoModal" class="btn btn-ghost">Cancelar</button>
                        <button type="submit" class="btn btn-primary">{{ $editEstadoMode ? 'Actualizar' : 'Crear' }}</button>
                    </div>
                </form>
            </div>
            <div class="modal-backdrop" wire:click="closeEstadoModal"></div>
        </div>
    @endif

    {{-- MODAL: Tarifa --}}
    @if($showTarifaModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">{{ $editTarifaMode ? 'Editar Tarifa' : 'Nueva Tarifa' }}</h3>
                
                <form wire:submit.prevent="saveTarifa">
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Concepto <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="tarifaConcepto" class="input input-bordered @error('tarifaConcepto') input-error @enderror" placeholder="Tarifa base" />
                        @error('tarifaConcepto')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Valor <span class="text-error">*</span></span>
                            </label>
                            <input type="number" step="0.01" wire:model="tarifaValor" class="input input-bordered @error('tarifaValor') input-error @enderror" placeholder="0.00" />
                            @error('tarifaValor')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Tipo <span class="text-error">*</span></span>
                            </label>
                            <select wire:model="tarifaTipo" class="select select-bordered @error('tarifaTipo') select-error @enderror">
                                <option value="fijo">Fijo</option>
                                <option value="por_km">Por Kilómetro</option>
                                <option value="por_kg">Por Kilogramo</option>
                            </select>
                            @error('tarifaTipo')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror  
                        </div>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Descripción</span>
                        </label>
                        <textarea wire:model="tarifaDescripcion" class="textarea textarea-bordered" rows="2" placeholder="Descripción opcional..."></textarea>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label cursor-pointer justify-start gap-4">
                            <input type="checkbox" wire:model="tarifaActivo" class="toggle toggle-success" />
                            <span class="label-text font-semibold">Tarifa Activa</span>
                        </label>
                    </div>

                    <div class="modal-action">
                        <button type="button" wire:click="closeTarifaModal" class="btn btn-ghost">Cancelar</button>
                        <button type="submit" class="btn btn-primary">{{ $editTarifaMode ? 'Actualizar' : 'Crear' }}</button>
                    </div>
                </form>
            </div>
            <div class="modal-backdrop" wire:click="closeTarifaModal"></div>
        </div>
    @endif

    {{-- MODAL: Tipo de Vehículo --}}
    @if($showTipoVehiculoModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">{{ $editTipoVehiculoMode ? 'Editar Tipo de Vehículo' : 'Nuevo Tipo de Vehículo' }}</h3>
                
                <form wire:submit.prevent="saveTipoVehiculo">
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Nombre <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="tipoVehiculoNombre" class="input input-bordered @error('tipoVehiculoNombre') input-error @enderror" placeholder="Camioneta" />
                        @error('tipoVehiculoNombre')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                   

                    <div class="modal-action">
                        <button type="button" wire:click="closeTipoVehiculoModal" class="btn btn-ghost">Cancelar</button>
                        <button type="submit" class="btn btn-primary">{{ $editTipoVehiculoMode ? 'Actualizar' : 'Crear' }}</button>
                    </div>
                </form>
            </div>
            <div class="modal-backdrop" wire:click="closeTipoVehiculoModal"></div>
        </div>
    @endif

    {{-- DELETE MODALS --}}
    @if($showEstadoDeleteModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4 text-error">Confirmar Eliminación</h3>
                <p class="py-4">¿Está seguro que desea eliminar este estado? Esta acción no se puede deshacer.</p>
                <div class="modal-action">
                    <button wire:click="cancelDeleteEstado" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="deleteEstado" class="btn btn-error">Eliminar</button>
                </div>
            </div>
            <div class="modal-backdrop" wire:click="cancelDeleteEstado"></div>
        </div>
    @endif

    @if($showTarifaDeleteModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4 text-error">Confirmar Eliminación</h3>
                <p class="py-4">¿Está seguro que desea eliminar esta tarifa? Esta acción no se puede deshacer.</p>
                <div class="modal-action">
                    <button wire:click="cancelDeleteTarifa" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="deleteTarifa" class="btn btn-error">Eliminar</button>
                </div>
            </div>
            <div class="modal-backdrop" wire:click="cancelDeleteTarifa"></div>
        </div>
    @endif

    @if($showTipoVehiculoDeleteModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4 text-error">Confirmar Eliminación</h3>
                <p class="py-4">¿Está seguro que desea eliminar este tipo de vehículo? Esta acción no se puede deshacer.</p>
                <div class="modal-action">
                    <button wire:click="cancelDeleteTipoVehiculo" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="deleteTipoVehiculo" class="btn btn-error">Eliminar</button>
                </div>
            </div>
            <div class="modal-backdrop" wire:click="cancelDeleteTipoVehiculo"></div>
        </div>
    @endif
</div>
