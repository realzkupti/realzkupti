<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - TailAdmin Template')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo flex items-center justify-between">
                <span>TailAdmin</span>
                <button id="darkModeToggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                    </svg>
                    <svg class="w-5 h-5 dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>
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

    <!-- Legacy Auth JS (will be migrated to Vite) -->
    <script src="/assets/js/auth.js"></script>

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
