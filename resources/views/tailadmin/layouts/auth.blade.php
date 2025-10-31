<!doctype html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'เข้าสู่ระบบ')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
      (function() {
        try {
          var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
          var stored = localStorage.getItem('theme');
          var enableDark = stored ? stored === 'dark' : prefersDark;
          if (enableDark) document.documentElement.classList.add('dark');
          else document.documentElement.classList.remove('dark');
        } catch(e) { /* no-op */ }
      })();
    </script>
    @stack('styles')
    <style>
      body { min-height: 100vh; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
  <main class="min-h-screen flex items-center justify-center">
    @yield('content')
  </main>

  @if(session('status'))
    <script>
      window.addEventListener('DOMContentLoaded', function(){
        alert(@json(session('status')));
      });
    </script>
  @endif

  @if(session('error'))
    <script>
      window.addEventListener('DOMContentLoaded', function(){
        alert(@json(session('error')));
      });
    </script>
  @endif

  @stack('scripts')
</body>
</html>
