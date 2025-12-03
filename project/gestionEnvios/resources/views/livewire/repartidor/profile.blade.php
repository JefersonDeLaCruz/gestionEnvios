<div class="p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Mi Perfil</h1>
        <p class="text-base-content/70 mt-1">Información personal y configuración</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body items-center text-center">
                    <!-- Avatar -->
                    <div class="avatar placeholder mb-4">
                        <div class="bg-primary text-primary-content rounded-full w-32">
                            <span class="text-5xl font-bold">JD</span>
                        </div>
                    </div>

                    <h2 class="card-title text-2xl">Juan Delgado</h2>
                    <p class="text-base-content/70">Repartidor Senior</p>

                    <div class="divider"></div>

                    <!-- Quick Stats -->
                    <div class="stats stats-vertical shadow w-full">
                        <div class="stat place-items-center">
                            <div class="stat-title">Experiencia</div>
                            <div class="stat-value text-primary">3 años</div>
                            <div class="stat-desc">Desde 2022</div>
                        </div>

                        <div class="stat place-items-center">
                            <div class="stat-title">Total Entregas</div>
                            <div class="stat-value text-success">4,523</div>
                            <div class="stat-desc">Tasa éxito: 96%</div>
                        </div>

                        <div class="stat place-items-center">
                            <div class="stat-title">Calificación</div>
                            <div class="stat-value text-warning">4.9</div>
                            <div class="stat-desc">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-block mt-4 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                        Cambiar Foto
                    </button>
                </div>
            </div>

            <!-- Vehicle Info -->
            <div class="card bg-base-100 shadow-xl mt-6">
                <div class="card-body">
                    <h3 class="card-title text-lg">Vehículo Asignado</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="text-4xl">🚚</div>
                            <div>
                                <div class="font-semibold">Ford Transit 2021</div>
                                <div class="text-sm text-base-content/60">Placa: ABC-1234</div>
                            </div>
                        </div>
                        <div class="divider my-2"></div>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <div class="text-base-content/60">Kilometraje</div>
                                <div class="font-semibold">45,230 km</div>
                            </div>
                            <div>
                                <div class="text-base-content/60">Último servicio</div>
                                <div class="font-semibold">15/11/2025</div>
                            </div>
                            <div>
                                <div class="text-base-content/60">Combustible</div>
                                <div class="font-semibold">Diesel</div>
                            </div>
                            <div>
                                <div class="text-base-content/60">Capacidad</div>
                                <div class="font-semibold">1,200 kg</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information & Settings -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Información Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nombre Completo</span>
                            </label>
                            <input type="text" value="Juan Delgado Martínez" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email" value="juan.delgado@skybox.com" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Teléfono</span>
                            </label>
                            <input type="tel" value="+52 555-1234-5678" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Fecha de Nacimiento</span>
                            </label>
                            <input type="date" value="1990-05-15" class="input input-bordered" />
                        </div>
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Dirección</span>
                            </label>
                            <input type="text" value="Calle Principal #123, Col. Centro, CDMX"
                                class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Licencia de Conducir</span>
                            </label>
                            <input type="text" value="A1234567890" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Vigencia Licencia</span>
                            </label>
                            <input type="date" value="2028-12-31" class="input input-bordered" />
                        </div>
                    </div>
                    <div class="card-actions justify-end mt-4">
                        <button class="btn btn-ghost">Cancelar</button>
                        <button class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>

            <!-- Work Schedule -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Horario de Trabajo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Hora de Inicio</span>
                            </label>
                            <input type="time" value="08:00" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Hora de Fin</span>
                            </label>
                            <input type="time" value="17:00" class="input input-bordered" />
                        </div>
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Días Laborales</span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                <label class="label cursor-pointer gap-2 bg-base-200 px-4 py-2 rounded-lg">
                                    <input type="checkbox" checked class="checkbox checkbox-sm" />
                                    <span class="label-text">Lunes</span>
                                </label>
                                <label class="label cursor-pointer gap-2 bg-base-200 px-4 py-2 rounded-lg">
                                    <input type="checkbox" checked class="checkbox checkbox-sm" />
                                    <span class="label-text">Martes</span>
                                </label>
                                <label class="label cursor-pointer gap-2 bg-base-200 px-4 py-2 rounded-lg">
                                    <input type="checkbox" checked class="checkbox checkbox-sm" />
                                    <span class="label-text">Miércoles</span>
                                </label>
                                <label class="label cursor-pointer gap-2 bg-base-200 px-4 py-2 rounded-lg">
                                    <input type="checkbox" checked class="checkbox checkbox-sm" />
                                    <span class="label-text">Jueves</span>
                                </label>
                                <label class="label cursor-pointer gap-2 bg-base-200 px-4 py-2 rounded-lg">
                                    <input type="checkbox" checked class="checkbox checkbox-sm" />
                                    <span class="label-text">Viernes</span>
                                </label>
                                <label class="label cursor-pointer gap-2 bg-base-200 px-4 py-2 rounded-lg">
                                    <input type="checkbox" class="checkbox checkbox-sm" />
                                    <span class="label-text">Sábado</span>
                                </label>
                                <label class="label cursor-pointer gap-2 bg-base-200 px-4 py-2 rounded-lg">
                                    <input type="checkbox" class="checkbox checkbox-sm" />
                                    <span class="label-text">Domingo</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Settings -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Configuración de Notificaciones</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div>
                                <div class="font-semibold">Nuevas Asignaciones</div>
                                <div class="text-sm text-base-content/60">Recibir notificación de nuevos paquetes</div>
                            </div>
                            <input type="checkbox" checked class="toggle toggle-primary" />
                        </div>
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div>
                                <div class="font-semibold">Recordatorios de Ruta</div>
                                <div class="text-sm text-base-content/60">Alertas de próximas entregas</div>
                            </div>
                            <input type="checkbox" checked class="toggle toggle-primary" />
                        </div>
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div>
                                <div class="font-semibold">Mensajes de Clientes</div>
                                <div class="text-sm text-base-content/60">Notificaciones de mensajes directos</div>
                            </div>
                            <input type="checkbox" checked class="toggle toggle-primary" />
                        </div>
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div>
                                <div class="font-semibold">Actualizaciones del Sistema</div>
                                <div class="text-sm text-base-content/60">Noticias y actualizaciones importantes</div>
                            </div>
                            <input type="checkbox" class="toggle toggle-primary" />
                        </div>
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div>
                                <div class="font-semibold">Reportes Semanales</div>
                                <div class="text-sm text-base-content/60">Resumen de rendimiento semanal</div>
                            </div>
                            <input type="checkbox" checked class="toggle toggle-primary" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Seguridad</h3>
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Contraseña Actual</span>
                            </label>
                            <input type="password" placeholder="••••••••" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nueva Contraseña</span>
                            </label>
                            <input type="password" placeholder="••••••••" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Confirmar Nueva Contraseña</span>
                            </label>
                            <input type="password" placeholder="••••••••" class="input input-bordered" />
                        </div>
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">La contraseña debe tener al menos 8 caracteres, incluir mayúsculas,
                                minúsculas y números.</span>
                        </div>
                        <div class="card-actions justify-end">
                            <button class="btn btn-primary">Cambiar Contraseña</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Contacto de Emergencia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nombre</span>
                            </label>
                            <input type="text" value="María Delgado" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Relación</span>
                            </label>
                            <select class="select select-bordered">
                                <option>Esposa</option>
                                <option>Esposo</option>
                                <option>Padre/Madre</option>
                                <option>Hermano/Hermana</option>
                                <option>Hijo/Hija</option>
                                <option>Otro</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Teléfono Principal</span>
                            </label>
                            <input type="tel" value="+52 555-9876-5432" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Teléfono Alternativo</span>
                            </label>
                            <input type="tel" placeholder="Opcional" class="input input-bordered" />
                        </div>
                    </div>
                    <div class="card-actions justify-end mt-4">
                        <button class="btn btn-primary">Actualizar Contacto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>