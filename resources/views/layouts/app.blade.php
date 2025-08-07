<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Mon Application')</title>
    {{-- Inclure tes assets CSS/JS (Vite, Mix ou autre) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex min-h-screen">

    {{-- Sidebar fixe à gauche --}}
    @include('layouts.partials.sidebar')

    {{-- Conteneur principal (laisse la place pour la sidebar) --}}
    <div class="flex-1 flex flex-col ml-64 min-h-screen">
        
        {{-- Navbar en haut --}}
        @include('layouts.partials.navbar')

        

        {{-- Zone contenu principale --}}
        <main class="flex-grow p-6 bg-gray-50">
            @yield('content')
        </main>

        {{-- Footer simple --}}
        <footer class="bg-white border-t border-gray-200 text-center py-4 text-sm text-gray-500">
            &copy; {{ date('Y') }} Mon Application. Tous droits réservés.
        </footer>

    </div>

</body>
</html>
