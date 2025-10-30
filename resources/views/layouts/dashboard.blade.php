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
                @if(isset($menus))
                    @foreach($menus as $menu)
                        @if($menu->children->isEmpty())
                            {{-- Menu without children --}}
                            <li>
                                <a href="{{ $menu->route ? route($menu->route) : '#' }}"
                                   class="{{ request()->routeIs($menu->route) ? 'active' : '' }}">
                                    <i class="icon-{{ $menu->icon }}"></i>
                                    {{ $menu->label }}
                                </a>
                            </li>
                        @else
                            {{-- Menu with children --}}
                            <li class="menu-item-has-children">
                                <a href="#" class="menu-parent">
                                    <i class="icon-{{ $menu->icon }}"></i>
                                    {{ $menu->label }}
                                    <span class="arrow">▼</span>
                                </a>
                                <ul class="submenu">
                                    @foreach($menu->children as $child)
                                        @if(Auth::user()->hasMenuPermission($child->id, 'can_view'))
                                            <li>
                                                <a href="{{ $child->route ? route($child->route) : '#' }}"
                                                   class="{{ request()->routeIs($child->route) ? 'active' : '' }}">
                                                    {{ $child->label }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif

                {{-- Profile & Logout (Always visible) --}}
                <li>
                    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="icon-user"></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="#" onclick="handleLogout(event)">
                        <i class="icon-logout"></i>
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
                logout: '{{ route('logout') }}',
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
