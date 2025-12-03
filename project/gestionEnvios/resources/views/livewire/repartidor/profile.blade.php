<div class="p-6 max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Mi Perfil</h1>
            <p class="text-base-content/70 mt-1">Gestiona tu información personal y seguridad</p>
        </div>
        <button wire:click="$set('showEditModal', true)"
            class="btn btn-primary gap-2 rounded-full px-6 shadow-lg hover:shadow-xl transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            Editar Perfil
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 space-y-6 ">
            <div class="h-full card bg-base-100 shadow-xl overflow-hidden border border-base-200">
                <div class="h-32 bg-gradient-to-r from-primary/10 to-secondary/10"></div>
                <div class="card-body pt-0 relative">
                    {{-- <div class="avatar placeholder -mt-16 mb-4 border-4 border-base-100 rounded-full w-fit">
                        <div
                            class="bg-neutral text-neutral-content rounded-full w-32 h-32 text-4xl font-bold shadow-md">
                            {{ substr($user->nombre, 0, 1) }}{{ substr($user->apellido, 0, 1) }}
                        </div>
                        <div class="absolute bottom-2 right-2 w-5 h-5 bg-success rounded-full border-2 border-base-100"
                            title="Activo"></div>
                    </div> --}}

                    <h2 class="text-2xl font-bold mt-3">{{ $user->nombre }} {{ $user->apellido }}</h2>
                    <div class="flex items-center gap-2 text-base-content/70 mt-1">
                        <span class="badge badge-ghost gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                            Repartidor
                        </span>
                        <span class="text-xs">•</span>
                        <span class="text-sm">Unido {{ $user->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="divider my-4"></div>

                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="p-3 bg-base-200/50 rounded-xl">
                            <div class="text-2xl font-bold text-primary">{{ $user->envios->count() }}</div>
                            <div class="text-xs text-base-content/60 font-medium uppercase tracking-wide">Entregas</div>
                        </div>
                        <div class="p-3 bg-base-200/50 rounded-xl">
                            <div class="text-2xl font-bold text-warning">4.9</div>
                            <div class="text-xs text-base-content/60 font-medium uppercase tracking-wide">Calificación
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Info Section -->
            <div class="card bg-base-100 shadow-xl border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
                        Información Personal
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <div class="text-xs text-base-content/50 uppercase font-bold tracking-wider">Email</div>
                            <div class="font-medium flex items-center gap-2">
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <div class="badge badge-success badge-xs gap-1 text-white" title="Verificado">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-2 h-2">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-xs text-base-content/50 uppercase font-bold tracking-wider">Teléfono</div>
                            <div class="font-medium">{{ $user->telefono ?? 'No registrado' }}</div>
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <div class="text-xs text-base-content/50 uppercase font-bold tracking-wider">Dirección</div>
                            <div class="font-medium">{{ $user->direccion ?? 'No registrada' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Info Section (Placeholder) -->
            <div class="card bg-base-100 shadow-xl border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-secondary">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                        Vehículo Asignado
                    </h3>

                    @if($user->vehiculoActivo())
                        <div class="flex items-center gap-4 p-4 bg-base-200/30 rounded-xl border border-base-200">
                            <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-2xl">
                                🚚
                            </div>
                            <div>
                                <div class="font-bold">{{ $user->vehiculoActivo()->marca }}
                                    {{ $user->vehiculoActivo()->modelo }}
                                </div>
                                <div class="text-sm text-base-content/70">Placa: {{ $user->vehiculoActivo()->placa }}</div>
                            </div>
                            <div class="ml-auto">
                                <span class="badge badge-success badge-sm">Activo</span>
                            </div>
                        </div>
                    @else
                        <div
                            class="text-center py-6 text-base-content/50 bg-base-200/30 rounded-xl border border-base-200 border-dashed">
                            <p>No tienes un vehículo asignado actualmente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    @if($showEditModal)
        <div class="modal modal-open backdrop-blur-sm">
            <div class="modal-box w-11/12 max-w-2xl p-0 overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-base-200/50 p-6 border-b border-base-300 flex justify-between items-center">
                    <h3 class="font-bold text-lg">Editar Perfil</h3>
                    <button wire:click="$set('showEditModal', false)" class="btn btn-sm btn-circle btn-ghost">✕</button>
                </div>

                <!-- Modal Tabs -->
                <div class="tabs tabs-boxed bg-base-100 p-4 justify-center gap-2">
                    <a class="tab {{ $activeTab === 'personal' ? 'tab-active' : '' }}"
                        wire:click="$set('activeTab', 'personal')">Datos Personales</a>
                    <a class="tab {{ $activeTab === 'security' ? 'tab-active' : '' }}"
                        wire:click="$set('activeTab', 'security')">Seguridad</a>
                </div>

                <div class="p-6">
                    <!-- Personal Data Form -->
                    @if($activeTab === 'personal')
                        <form wire:submit.prevent="updateProfile" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name (Read-only) -->
                                <div class="relative group">
                                    <label class="text-xs font-bold text-base-content/50 uppercase ml-1">Nombre Completo</label>
                                    <input type="text" value="{{ $name }}" disabled
                                        class="input input-bordered w-full mt-1 bg-base-200/50 cursor-not-allowed" />
                                    <span class="text-xs text-base-content/40 ml-1 mt-1 block">Contacta a soporte para cambiar
                                        tu nombre.</span>
                                </div>

                                <!-- Email -->
                                <div class="relative group">
                                    <label class="text-xs font-bold text-base-content/50 uppercase ml-1">Email</label>
                                    <input type="email" wire:model="email"
                                        class="input input-bordered w-full mt-1 focus:input-primary" />
                                    @error('email') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Phone -->
                                <div class="relative group">
                                    <label class="text-xs font-bold text-base-content/50 uppercase ml-1">Teléfono</label>
                                    <input type="tel" wire:model.blur="phone" placeholder="0000-0000" maxlength="9"
                                        x-on:input="$el.value = $el.value.replace(/\D/g, '').substring(0, 8).replace(/^(\d{4})(\d)/, '$1-$2')"
                                        class="input input-bordered w-full mt-1 focus:input-primary" />
                                    @error('phone') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Address -->
                                <div class="relative group md:col-span-2">
                                    <label class="text-xs font-bold text-base-content/50 uppercase ml-1">Dirección</label>
                                    <input type="text" wire:model="address"
                                        class="input input-bordered w-full mt-1 focus:input-primary" />
                                    @error('address') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="modal-action">
                                <button type="button" wire:click="$set('showEditModal', false)"
                                    class="btn btn-ghost">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    @endif

                    <!-- Security Form -->
                    @if($activeTab === 'security')
                        <form wire:submit.prevent="updatePassword" class="space-y-4">
                            <div class="alert alert-warning shadow-sm text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Asegúrate de usar una contraseña segura.</span>
                            </div>

                            <div class="relative group">
                                <label class="text-xs font-bold text-base-content/50 uppercase ml-1">Contraseña Actual</label>
                                <input type="password" wire:model="current_password"
                                    class="input input-bordered w-full mt-1 focus:input-primary" />
                                @error('current_password') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="relative group">
                                <label class="text-xs font-bold text-base-content/50 uppercase ml-1">Nueva Contraseña</label>
                                <input type="password" wire:model="new_password"
                                    class="input input-bordered w-full mt-1 focus:input-primary" />
                                @error('new_password') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="relative group">
                                <label class="text-xs font-bold text-base-content/50 uppercase ml-1">Confirmar Nueva
                                    Contraseña</label>
                                <input type="password" wire:model="new_password_confirmation"
                                    class="input input-bordered w-full mt-1 focus:input-primary" />
                            </div>

                            <div class="modal-action">
                                <button type="button" wire:click="$set('showEditModal', false)"
                                    class="btn btn-ghost">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>