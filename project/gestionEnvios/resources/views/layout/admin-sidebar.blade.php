<div class="drawer-side is-drawer-close:overflow-visible z-20">
    <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
    <div class="flex min-h-full flex-col items-start bg-base-200 is-drawer-close:w-50 is-drawer-open:w-64 transition-all duration-300">
        <ul class="menu w-full grow gap-2 border-r border-base-300 pt-10">
            
            <li>
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tip="Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round"
                        stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"
                        class="my-1.5 inline-block size-5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.packages') }}" wire:navigate class="flex is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->routeIs('admin.packages') ? 'active' : '' }}" data-tip="Paquetes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <span class="font-medium">Paquetes y Envíos</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users') }}" wire:navigate class="flex is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->routeIs('admin.users') ? 'active' : '' }}" data-tip="Usuarios">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span class="font-medium">Usuarios</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.fleet') }}" wire:navigate class="flex is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->routeIs('admin.fleet') ? 'active' : '' }}" data-tip="Flota">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                    <span class="font-medium">Flota y Rutas</span>
                </a>
            </li>

             <li>
                <a href="{{ route('admin.reports') }}" wire:navigate class="flex is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->routeIs('admin.reports') ? 'active' : '' }}" data-tip="Reportes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span class="font-medium">Reportes e Historial</span>
                </a>
            </li>

            <div class="mt-auto w-full border-t border-base-300 my-2"></div>

            <li>
                <a href="{{ route('admin.settings') }}" wire:navigate class="flex is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->routeIs('admin.settings') ? 'active' : '' }}" data-tip="Configuración">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round"
                        stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"
                        class="my-1.5 inline-block size-5">
                        <path d="M20 7h-9"></path>
                        <path d="M14 17H5"></path>
                        <circle cx="17" cy="17" r="3"></circle>
                        <circle cx="7" cy="7" r="3"></circle>
                    </svg>
                    <span class="font-medium">Configuración</span>
                </a>
            </li>
        </ul>
    </div>
</div>