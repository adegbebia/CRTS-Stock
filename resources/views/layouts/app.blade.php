<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'CRTS STOCK')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>

</head>
<body class="min-h-screen flex flex-col bg-white">

    @include('layouts.navbar')

    <div class="flex flex-1 min-h-0">
        <!-- Sidebar - uniquement pour les utilisateurs authentifiés -->
        @auth
        <div id="sidebar" class="hidden md:block w-64 bg-white text-gray-800 p-4 transition-all duration-300 transform border-r border-gray-200">
            @include('layouts.sidebar')
        </div>
        @endauth

        <!-- Contenu principal -->
        <main class="flex-1 flex flex-col overflow-auto bg-white @yield('main-class', 'p-4 md:p-6')">
            @yield('content')
        </main>
    </div>

    @include('layouts.footer')

    {{-- <!-- Bouton toggle amélioré -->
    <button id="toggleSidebar" class="fixed top-4 left-4 z-50 btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button> --}}

    <!-- Script de bascule -->
    <script>
        document.getElementById('toggleSidebar')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            
            // Solution optimale combinant translation et suppression d'espace
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('w-0');
            sidebar.classList.toggle('overflow-hidden');
        });
    </script>

    <!-- Alpine.js chargé localement via resources/js/app.js -->
    @stack('scripts')
</body>
</html>