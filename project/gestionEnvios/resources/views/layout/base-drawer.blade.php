<!DOCTYPE html>
<html lang="en" data-theme="black">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title', 'Mi App')</title>
    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>

    <div class="drawer lg:drawer-open">
        <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">

            @persist('navbar')
                @include('layout.navbar')
            @endpersist
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- Sidebar -->
        <!-- IMPORTANTE -->
        @if(Auth::user()->hasRole('repartidor'))

            @include('layout.repartidor-sidebar')

        @elseif(Auth::user()->hasRole('admin'))

            @include('layout.admin-sidebar')

        @endif
    </div>



    <script>
        // Fix theme persistence with Livewire navigation
        document.addEventListener('livewire:navigated', () => {
            // Manually reapply theme from localStorage after Livewire navigation
            const theme = localStorage.getItem('theme');
            if (theme) {
                document.documentElement.setAttribute('data-theme', theme);
            }
        });
    </script>

    @livewireScripts
</body>

</html>