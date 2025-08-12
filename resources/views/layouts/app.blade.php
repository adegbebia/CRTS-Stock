<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'CRTS STOCK')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles Tailwind/DaisyUI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen flex flex-col bg-gray-50">

    @include('layouts.navbar')

    <div class="flex flex-1">
        <!-- Sidebar avec gestion complète de l'affichage -->
        <div id="sidebar" class="w-64 bg-base-200 p-4  transition-all duration-300 transform">
            @include('layouts.sidebar')
        </div>

        <!-- Contenu principal - sans marge gauche initiale -->
        <main class="flex-1 p-6 overflow-auto">
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
        <!-- Script de bascule -->
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            
            // Solution optimale combinant translation et suppression d'espace
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('w-0');
            sidebar.classList.toggle('overflow-hidden');
        });
    </script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>