<div class="p-6">
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Gestión de Repartidores</h1>
        <p class="text-base-content/70 mt-1">Administra los repartidores del sistema</p>
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

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Repartidores</div>
                <div class="stat-value text-primary">{{ $totalUsers }}</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Activos</div>
                <div class="stat-value text-success">{{ $activeUsers }}</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Dados de Baja</div>
                <div class="stat-value text-error">{{ $inactiveUsers }}</div>
            </div>
        </div>
    </div>

    {{-- Filters and Actions --}}
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <div class="flex flex-col lg:flex-row gap-4 justify-between items-center">
                {{-- Search --}}
                <div class="form-control w-full lg:w-96">
                    <div class="input-group flex flex-row gap-2">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre, email o teléfono..." class="input input-bordered w-full" />
                        <!-- <button class="btn btn-square">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button> -->
                    </div>
                </div>

                <div class="flex gap-4 w-full lg:w-auto">
                    {{-- Status Filter --}}
                    <select wire:model.live="statusFilter" class="select select-bordered w-full lg:w-48">
                        <option value="">Todos los estados</option>
                        <option value="1">Activos</option>
                        <option value="0">Dados de baja</option>
                    </select>

                    {{-- Create Button --}}
                    <button wire:click="openCreateModal" class="btn btn-primary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo Repartidor
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="hover">
                                <td class="font-mono">{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-12">
                                                <span class="text-lg">{{ substr($user->nombre, 0, 1) }}{{ substr($user->apellido, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">{{ $user->nombre }} {{ $user->apellido }}</div>
                                            <div class="text-sm opacity-50">Repartidor</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-sm">{{ $user->telefono }}</span>
                                    </div>
                                </td>
                                <td class="text-sm max-w-xs truncate" title="{{ $user->direccion }}">{{ $user->direccion }}</td>
                                <td>
                                    @if($user->estado)
                                        <span class="badge badge-success gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge badge-error gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        {{-- Edit Button --}}
                                        <button wire:click="openEditModal({{ $user->id }})" class="btn btn-ghost btn-sm" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- Toggle Status Button --}}
                                        <button wire:click="toggleStatus({{ $user->id }})" 
                                                class="btn btn-ghost btn-sm {{ $user->estado ? 'text-warning' : 'text-success' }}" 
                                                title="{{ $user->estado ? 'Dar de baja' : 'Activar' }}">
                                            @if($user->estado)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </button>

                                        {{-- Delete Button --}}
                                        <button wire:click="confirmDelete({{ $user->id }})" class="btn btn-ghost btn-sm text-error" title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12">
                                    <div class="flex flex-col items-center gap-2 text-base-content/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p class="font-semibold text-lg">No se encontraron repartidores</p>
                                        <p class="text-sm">{{ $search ? 'Intenta ajustar los filtros de búsqueda' : 'Comienza creando un nuevo repartidor' }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
        <div class="modal modal-open">
            <div class="modal-box max-w-2xl">
                <h3 class="font-bold text-lg mb-4">{{ $editMode ? 'Editar Repartidor' : 'Nuevo Repartidor' }}</h3>
                
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nombre --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nombre <span class="text-error">*</span></span>
                            </label>
                            <input type="text" wire:model="nombre" class="input input-bordered @error('nombre') input-error @enderror" placeholder="Juan" />
                            @error('nombre')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        {{-- Apellido --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Apellido <span class="text-error">*</span></span>
                            </label>
                            <input type="text" wire:model="apellido" class="input input-bordered @error('apellido') input-error @enderror" placeholder="Pérez" />
                            @error('apellido')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Email <span class="text-error">*</span></span>
                            </label>
                            <input type="email" wire:model="email" class="input input-bordered @error('email') input-error @enderror" placeholder="juan@example.com" />
                            @error('email')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Teléfono <span class="text-error">*</span></span>
                            </label>
                            <input type="text" wire:model="telefono" class="input input-bordered @error('telefono') input-error @enderror" placeholder="555-1234" />
                            @error('telefono')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Dirección <span class="text-error">*</span></span>
                            </label>
                            <input type="text" wire:model="direccion" class="input input-bordered @error('direccion') input-error @enderror" placeholder="Calle Principal #123" />
                            @error('direccion')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Contraseña @if(!$editMode)<span class="text-error">*</span>@endif</span>
                            </label>
                            <input type="password" wire:model="password" class="input input-bordered @error('password') input-error @enderror" placeholder="••••••••" />
                            @error('password')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            @if($editMode)
                                <label class="label">
                                    <span class="label-text-alt">Dejar en blanco para mantener la actual</span>
                                </label>
                            @endif
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Confirmar Contraseña @if(!$editMode)<span class="text-error">*</span>@endif</span>
                            </label>
                            <input type="password" wire:model="password_confirmation" class="input input-bordered @error('password_confirmation') input-error @enderror" placeholder="••••••••" />
                            @error('password_confirmation')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="form-control md:col-span-2">
                            <label class="label cursor-pointer justify-start gap-4">
                                <input type="checkbox" wire:model="estado" value="1" class="toggle toggle-success" />
                                <span class="label-text font-semibold">Repartidor Activo</span>
                            </label>
                        </div>
                    </div>

                    <div class="modal-action">
                        <button type="button" wire:click="closeModal" class="btn btn-ghost">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            {{ $editMode ? 'Actualizar' : 'Crear' }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-backdrop" wire:click="closeModal"></div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4 text-error">Confirmar Eliminación</h3>
                <p class="py-4">¿Está seguro que desea eliminar este repartidor? Esta acción no se puede deshacer.</p>
                
                <div class="modal-action">
                    <button wire:click="cancelDelete" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="deleteUser" class="btn btn-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Eliminar
                    </button>
                </div>
            </div>
            <div class="modal-backdrop" wire:click="cancelDelete"></div>
        </div>
    @endif
</div>
