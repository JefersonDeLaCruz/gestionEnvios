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
    <header>
        @yield('navbar')
    </header>
    

    <main>
        @yield('content')
    </main>

    <footer>
        @yield('footer')
    </footer>
    @livewireScripts
 
</body>
</html>