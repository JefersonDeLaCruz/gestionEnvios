<div class="p-6">
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Gestión de Usuarios</h1>
        <p class="text-base-content/70 mt-1">Administra los usuarios del sistema</p>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success mb-6 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Error Message --}}
    @if (session()->has('error'))
        <div class="alert alert-error mb-6 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Usuarios</div>
                <div class="stat-value text-primary">{{ $totalUsers }}</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Activos</div>
                <div class="stat-value text-success">{{ $activeUsers }}</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Buscar por nombre, email o teléfono..." class="input input-bordered w-full" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo Usuario
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
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="hover">
                                <td class="font-mono">{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="font-bold">{{ $user->nombre }} {{ $user->apellido }}</div>
                                            @php
                                                $roleName = $user->getRoleNames()->first() ?? 'Sin rol';
                                                $badgeClass = match ($roleName) {
                                                    'admin' => 'badge-error',
                                                    'repartidor' => 'badge-info',
                                                    'usuario' => 'badge-success',
                                                    default => 'badge-ghost',
                                                };
                                            @endphp
                                            <span
                                                class="badge {{ $badgeClass }} badge-sm capitalize">{{ $roleName }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/70"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/70"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-sm">{{ $user->telefono }}</span>
                                    </div>
                                </td>
                                <td class="text-sm max-w-xs truncate" title="{{ $user->direccion }}">
                                    {{ $user->direccion }}</td>
                                <td>
                                    @if ($user->estado)
                                        <span class="badge badge-success gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge badge-error gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="flex gap-2 justify-center">
                                        {{-- Edit Button --}}
                                        <button wire:click="openEditModal({{ $user->id }})"
                                            class="btn btn-ghost btn-sm" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- Toggle Status Button --}}
                                        <button wire:click="toggleStatus({{ $user->id }})"
                                            class="btn btn-ghost btn-sm {{ $user->estado ? 'text-warning' : 'text-success' }}"
                                            title="{{ $user->estado ? 'Dar de baja' : 'Activar' }}">
                                            @if ($user->estado)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </button>


                                        {{-- Delete Button --}}
                                        @if ($user->id !== auth()->id())
                                            <button wire:click="confirmDelete({{ $user->id }})"
                                                class="btn btn-ghost btn-sm text-error" title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @else
                                            <div class="tooltip tooltip-left"
                                                data-tip="No puedes eliminar tu propia cuenta">
                                                <button
                                                    class="btn btn-ghost btn-sm text-base-content/30 cursor-not-allowed"
                                                    disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12">
                                    <div class="flex flex-col items-center gap-2 text-base-content/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p class="font-semibold text-lg">No se encontraron usuarios</p>
                                        <p class="text-sm">
                                            {{ $search ? 'Intenta ajustar los filtros de búsqueda' : 'Comienza creando un nuevo usuario' }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if ($showModal)
        <div class="modal modal-open">
            <div class="modal-box max-w-2xl border border-base-300">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold">{{ $editMode ? 'Editar' : 'Nuevo' }} Usuario</h2>
                    <button wire:click="closeModal" class="btn btn-sm btn-circle btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Nombre --}}
                        <div class="relative">
                            <input type="text" wire:model="nombre" id="nombre" placeholder=" "
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                       @error('nombre') border-error @else border-base-300 @enderror">
                            <label for="nombre"
                                class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                       @error('nombre') !-translate-y-4 !scale-75 !top-2 @enderror">
                                Nombre
                            </label>
                            @error('nombre')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Apellido --}}
                        <div class="relative">
                            <input type="text" wire:model="apellido" id="apellido" placeholder=" "
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                       @error('apellido') border-error @else border-base-300 @enderror">
                            <label for="apellido"
                                class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                       @error('apellido') !-translate-y-4 !scale-75 !top-2 @enderror">
                                Apellido
                            </label>
                            @error('apellido')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="relative col-span-2">
                            <input type="email" wire:model="email" id="email" placeholder=" "
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                       @error('email') border-error @else border-base-300 @enderror">
                            <label for="email"
                                class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                       @error('email') !-translate-y-4 !scale-75 !top-2 @enderror">
                                Email
                            </label>
                            @error('email')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="relative">
                            <input type="text" wire:model.blur="telefono" id="telefono" placeholder="0000-0000" maxlength="9"
                                x-on:input="$el.value = $el.value.replace(/\D/g, '').substring(0, 8).replace(/^(\d{4})(\d)/, '$1-$2')"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                       @error('telefono') border-error @else border-base-300 @enderror">
                            <label for="telefono"
                                class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                       @error('telefono') !-translate-y-4 !scale-75 !top-2 @enderror">
                                Teléfono
                            </label>
                            @error('telefono')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="relative">
                            <input type="text" wire:model="direccion" id="direccion" placeholder=" "
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                       @error('direccion') border-error @else border-base-300 @enderror">
                            <label for="direccion"
                                class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                       @error('direccion') !-translate-y-4 !scale-75 !top-2 @enderror">
                                Dirección
                            </label>
                            @error('direccion')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>


                        {{-- Contraseña --}}
                        <div class="relative">
                            <div x-data="{ showPassword: false }" class="relative">
                                <input :type="showPassword ? 'text' : 'password'" wire:model="password" id="password"
                                    placeholder=" "
                                    class="block px-2.5 pb-2.5 pt-4 pr-10 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                      @error('password') border-error @else border-base-300 @enderror">
                                <label for="password"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                      @error('password') !-translate-y-4 !scale-75 !top-2 @enderror">
                                    Contraseña
                                </label>
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-2 top-4 text-base-content/60 hover:text-base-content transition-colors z-20">
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"
                                        style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            @if ($editMode)
                                <span class="text-xs text-base-content/60 mt-1 block">Dejar en blanco para mantener la
                                    actual</span>
                            @endif
                        </div>

                        {{-- Confirmar Contraseña --}}
                        <div class="relative">
                            <div x-data="{ showPasswordConfirmation: false }" class="relative">
                                <input :type="showPasswordConfirmation ? 'text' : 'password'"
                                    wire:model="password_confirmation" id="password_confirmation" placeholder=" "
                                    class="block px-2.5 pb-2.5 pt-4 pr-10 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                      @error('password_confirmation') border-error @else border-base-300 @enderror">
                                <label for="password_confirmation"
                                    class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                      @error('password_confirmation') !-translate-y-4 !scale-75 !top-2 @enderror">
                                    Confirmar Contraseña
                                </label>
                                <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation"
                                    class="absolute right-2 top-4 text-base-content/60 hover:text-base-content transition-colors z-20">
                                    <svg x-show="!showPasswordConfirmation" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="showPasswordConfirmation" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>


                        {{-- Rol del Usuario --}}
                        <div class="relative col-span-2">
                            <select wire:model="role" id="role"
                                class="peer w-full px-4 pt-6 pb-2 bg-transparent border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition-all
                                       @error('role') border-error @else border-base-300 @enderror">
                                <option value="">Selecciona un rol</option>
                                {{-- <option value="usuario">Usuario</option> --}}
                                <option value="repartidor">Repartidor</option>
                                <option value="admin">Administrador</option>
                            </select>
                            <label for="role"
                                class="absolute left-4 top-2 text-xs text-base-content/60 bg-base-100 px-1">
                                Rol del Usuario
                            </label>
                            @error('role')
                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Estado Toggle --}}

                    </div>

                    <div class="modal-action">
                        <button type="button" wire:click="closeModal" class="btn btn-ghost rounded-full font-bold">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary rounded-full font-bold">
                            {{ $editMode ? 'Actualizar' : 'Crear' }} Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4 text-error">Confirmar Eliminación</h3>
                <p class="py-4">¿Está seguro que desea eliminar este usuario? Esta acción no se puede deshacer.</p>

                <div class="modal-action">
                    <button wire:click="cancelDelete" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="deleteUser" class="btn btn-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Eliminar
                    </button>
                </div>
            </div>
            <div class="modal-backdrop" wire:click="cancelDelete"></div>
        </div>
    @endif
</div>
