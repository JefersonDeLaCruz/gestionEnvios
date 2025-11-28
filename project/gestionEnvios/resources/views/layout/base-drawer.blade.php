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
            <!-- Navbar -->
            @include('layout.navbar')
            <!-- Page content here -->
            <main>
                @yield('content')
            </main>
        </div>
        @yield('sidebar')
    </div>


    @livewireScripts
</body>

</html>