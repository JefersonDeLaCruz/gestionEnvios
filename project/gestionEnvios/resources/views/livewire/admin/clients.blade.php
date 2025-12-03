<div class="p-6">
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Gestión de Clientes</h1>
        <p class="text-base-content/70 mt-1">Administra los clientes del sistema</p>
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
                <div class="stat-title">Total Clientes</div>
                <div class="stat-value text-primary">{{ $totalClients }}</div>
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
                            placeholder="Buscar por nombre, email, teléfono, DUI..." class="input input-bordered w-full" />
                    </div>
                </div>

                <div class="flex gap-4 w-full lg:w-auto">
                    {{-- Create Button --}}
                    <button wire:click="openCreateModal" class="btn btn-primary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo Cliente
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Clients Table --}}
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
                            <th>Documentos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                        <tr class="hover">
                            <td class="font-mono">{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-bold">{{ $client->nombre }} {{ $client->apellido }}</div>
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
                                    <span class="text-sm">{{ $client->email }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/70"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-sm">{{ $client->telefono }}</span>
                                </div>
                            </td>
                            <td class="text-sm max-w-xs truncate" title="{{ $client->direccion }}">
                                {{ $client->direccion }}
                            </td>
                            <td>
                                <div class="text-xs">
                                    @if($client->dui)
                                    <span class="badge badge-ghost badge-sm">DUI: {{ $client->dui }}</span>
                                    @endif
                                    @if($client->nit)
                                    <span class="badge badge-ghost badge-sm">NIT: {{ $client->nit }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex gap-2 justify-center">
                                    {{-- Edit Button --}}
                                    <button wire:click="openEditModal({{ $client->id }})"
                                        class="btn btn-ghost btn-sm" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    {{-- Delete Button --}}
                                    <button wire:click="confirmDelete({{ $client->id }})"
                                        class="btn btn-ghost btn-sm text-error" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center gap-2 text-base-content/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="font-semibold text-lg">No se encontraron clientes</p>
                                    <p class="text-sm">
                                        {{ $search ? 'Intenta ajustar los filtros de búsqueda' : 'Comienza creando un nuevo cliente' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($clients->hasPages())
            <div class="mt-4">
                {{ $clients->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if ($showModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-2xl border border-base-300">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">{{ $editMode ? 'Editar' : 'Nuevo' }} Cliente</h2>
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

                    {{-- DUI --}}
                    <div class="relative">
                        <input type="text" wire:model.blur="dui" id="dui" placeholder="00000000-0" maxlength="10"
                            x-on:input="$el.value = $el.value.replace(/\D/g, '').substring(0, 9).replace(/^(\d{8})(\d)/, '$1-$2')"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                       @error('dui') border-error @else border-base-300 @enderror">
                        <label for="dui"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                       @error('dui') !-translate-y-4 !scale-75 !top-2 @enderror">
                            DUI
                        </label>
                        @error('dui')
                        <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- NIT --}}
                    <div class="relative">
                        <input type="text" wire:model.blur="nit" id="nit" placeholder="0000-000000-000-0" maxlength="17"
                            x-on:input="
                                    let v = $el.value.replace(/\D/g, '').substring(0, 14);
                                    if (v.length > 13) v = v.replace(/^(\d{4})(\d{6})(\d{3})(\d)/, '$1-$2-$3-$4');
                                    else if (v.length > 10) v = v.replace(/^(\d{4})(\d{6})(\d)/, '$1-$2-$3');
                                    else if (v.length > 4) v = v.replace(/^(\d{4})(\d)/, '$1-$2');
                                    $el.value = v;
                                "
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-base-content bg-transparent rounded-md border appearance-none focus:outline-none focus:ring-0 focus:border-secondary peer
                                       @error('nit') border-error @else border-base-300 @enderror">
                        <label for="nit"
                            class="absolute text-sm text-base-content/60 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-base-100 px-2 peer-focus:px-2 peer-focus:text-secondary peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
                                       @error('nit') !-translate-y-4 !scale-75 !top-2 @enderror">
                            NIT
                        </label>
                        @error('nit')
                        <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="modal-action">
                    <button type="button" wire:click="closeModal" class="btn btn-ghost rounded-full font-bold">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-full font-bold">
                        {{ $editMode ? 'Actualizar' : 'Crear' }} Cliente
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
            <p class="py-4">¿Está seguro que desea eliminar este cliente? Esta acción no se puede deshacer.</p>

            <div class="modal-action">
                <button wire:click="cancelDelete" class="btn btn-ghost">Cancelar</button>
                <button wire:click="deleteClient" class="btn btn-error">
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