<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TailAdmin Template')</title>

    <!-- TailAdmin CSS with cache busting -->
    <link rel="stylesheet" href="/assets/css/tailadmin.css?v={{ config('app.asset_version', '1.0.0') }}">

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
                logout: '{{ route('api.logout') }}',
            }
        };
    </script>

    <!-- TailAdmin JavaScript with cache busting -->
    <script src="/assets/js/auth.js?v={{ config('app.asset_version', '1.0.0') }}"></script>

    @stack('scripts')
</body>
</html>
