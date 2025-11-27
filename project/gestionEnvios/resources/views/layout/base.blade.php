<!DOCTYPE html>
<html lang="en" data-theme="synthwave">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title', 'Mi App')</title>
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