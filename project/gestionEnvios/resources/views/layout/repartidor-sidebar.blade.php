<div class="drawer-side is-drawer-close:overflow-visible z-20">
    <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
    <div class="flex min-h-full flex-col items-start bg-base-200 is-drawer-close:w-50 is-drawer-open:w-64 transition-all duration-300">
        <ul class="menu w-full grow gap-2 border-r border-base-300 pt-10">
            
            <li>
                <a href="{{ route('repartidor.dashboard') }}" wire:navigate 
                   class="flex {{ request()->routeIs('repartidor.dashboard') ? 'active' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right" 
                   data-tip="Inicio">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('repartidor.route') }}" wire:navigate 
                   class="flex {{ request()->routeIs('repartidor.route') ? 'active' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right" 
                   data-tip="Mi Ruta">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                        <line x1="8" y1="2" x2="8" y2="18"></line>
                        <line x1="16" y1="6" x2="16" y2="22"></line>
                    </svg>
                    <span class="font-medium">Ruta del Día</span>
                </a>
            </li>

            <li>
                <a href="{{ route('repartidor.packages') }}" wire:navigate 
                   class="flex {{ request()->routeIs('repartidor.packages') ? 'active' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right" 
                   data-tip="Mis Paquetes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <span class="font-medium">Carga / Entregas</span>
                </a>
            </li>

            <li>
                <a href="{{ route('repartidor.history') }}" wire:navigate 
                   class="flex {{ request()->routeIs('repartidor.history') ? 'active' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right" 
                   data-tip="Historial">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="my-1.5 inline-block size-5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span class="font-medium">Historial</span>
                </a>
            </li>

            <div class="mt-auto w-full border-t border-base-300 my-2"></div>

            <li>
                <a href="{{ route('repartidor.profile') }}" wire:navigate 
                   class="flex {{ request()->routeIs('repartidor.profile') ? 'active' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right" 
                   data-tip="Mi Perfil">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round"
                        stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"
                        class="my-1.5 inline-block size-5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="font-medium">Mi Perfil</span>
                </a>
            </li>
        </ul>
    </div>
</div>