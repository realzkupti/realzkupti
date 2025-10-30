<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - TailAdmin Template')</title>

    <!-- TailAdmin CSS with cache busting -->
    <link rel="stylesheet" href="/assets/css/tailadmin.css?v={{ config('app.asset_version', '1.0.0') }}">

    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                TailAdmin
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg style="display: inline-block; width: 20px; height: 20px; margin-right: 8px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                        <svg style="display: inline-block; width: 20px; height: 20px; margin-right: 8px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="#" onclick="handleLogout(event)">
                        <svg style="display: inline-block; width: 20px; height: 20px; margin-right: 8px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Global App Config for JavaScript -->
    <script>
        window.App = {
            baseUrl: '{{ url('/') }}',
            apiUrl: '{{ url('/api') }}',
            csrfToken: '{{ csrf_token() }}',
            routes: {
                login: '{{ route('login') }}',
                dashboard: '{{ route('dashboard') }}',
                logout: '{{ route('api.logout') }}',
                admin: {
                    users: '{{ route('admin.users') }}',
                    menus: '{{ route('admin.menus') }}',
                    departments: '{{ route('admin.departments') }}',
                    companies: '{{ route('admin.companies') }}',
                    branches: '{{ route('admin.branches') }}',
                }
            }
        };
    </script>

    <!-- TailAdmin JavaScript with cache busting -->
    <script src="/assets/js/auth.js?v={{ config('app.asset_version', '1.0.0') }}"></script>

    <script>
    async function handleLogout(event) {
        event.preventDefault();

        if (!confirm('Are you sure you want to logout?')) {
            return;
        }

        try {
            const response = await auth.logout();

            if (response.success) {
                auth.showNotification(response.message, 'success');

                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = response.redirect;
                }, 500);
            }
        } catch (error) {
            auth.showNotification(error.message || 'Logout failed', 'error');
        }
    }
    </script>

    @stack('scripts')
</body>
</html>
