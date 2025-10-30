<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TailAdmin Template')</title>

    <!-- TailAdmin CSS -->
    <link rel="stylesheet" href="/assets/css/tailadmin.css">

    @stack('styles')
</head>
<body>
    @yield('content')

    <!-- TailAdmin JavaScript -->
    <script src="/assets/js/auth.js"></script>

    @stack('scripts')
</body>
</html>
