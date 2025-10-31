<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TailAdmin Template')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    @yield('content')

    <!-- Global App Config for JavaScript -->
    <script>
        window.App = {
            baseUrl: '{{ url('/') }}',
            apiUrl: '{{ url('/api') }}',
            csrfToken: '{{ csrf_token() }}',
            routes: {
                login: '{{ route('login') }}',
                register: '{{ route('register') }}',
                dashboard: '{{ route('dashboard') }}',
                logout: '{{ route('logout') }}',
            }
        };
    </script>

    <!-- Legacy Auth JS (will be migrated to Vite) -->
    <script src="/assets/js/auth.js"></script>

    @stack('scripts')
</body>
</html>
