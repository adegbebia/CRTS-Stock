<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CRTS Stock</title>

    {{-- Tailwind & JS compilés avec Vite --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-950 min-h-screen flex items-center justify-center p-4 overflow-hidden">

    <!-- Carré de connexion responsive avec animation slide from left -->
    <div class="w-11/12 max-w-[600px] aspect-square bg-white/95 backdrop-blur-sm shadow-2xl rounded-2xl p-10 space-y-6 border border-blue-100/30 transform transition-all duration-500 animate-slide-from-left">
        
        <!-- Logo + Titre -->
        <div class="text-center animate-fade-in-delay-1">
            <div class="relative inline-block animate-pulse-slow">
                <img src="{{ asset('images/logo-crts.png') }}" 
                     alt="Logo CRTS" 
                     class="mx-auto h-24 w-24 rounded-full shadow-xl border-4 border-red-600 bg-white p-2 transition-all duration-300 hover:rotate-6" />
                <div class="absolute inset-0 rounded-full border-2 border-red-600/30 animate-ping"></div>
            </div>

            <h1 class="mt-6 text-3xl font-extrabold text-blue-900">
                Bienvenue sur <span class="text-red-600">CRTS Stock</span>
            </h1>
            <p class="mt-2 text-gray-600">Veuillez vous connecter pour accéder à votre espace</p>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-fade-in-delay-2">
            @csrf

            <!-- Affichage erreur simple -->
            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm border-l-4 border-red-600 animate-shake">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Nom Pseudo -->
            <div class="group">
                <label for="nom_pseudo" class="block text-sm font-medium text-blue-900">Nom Pseudo</label>
                <div class="relative mt-2">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user text-gray-400 group-focus-within:text-red-600 transition-colors"></i>
                    </div>
                    <input id="nom_pseudo" 
                           name="nom_pseudo"
                           required
                           placeholder="Entrez votre identifiant"
                           class="mt-1 block w-full rounded-lg border border-blue-200 shadow-sm focus:border-red-500 
                                  focus:ring-2 focus:ring-red-500/20 sm:text-sm pl-11 pr-4 py-2.5 transition-all duration-300
                                  hover:border-blue-300" />
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="group">
                <label for="password" class="block text-sm font-medium text-blue-900">Mot de passe</label>
                <div class="relative mt-2">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-red-600 transition-colors"></i>
                    </div>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           oninput="handleInput()"
                           placeholder="••••••••"
                           class="block w-full rounded-lg border border-blue-200 shadow-sm focus:border-red-500 
                                  focus:ring-2 focus:ring-red-500/20 sm:text-sm pl-11 pr-11 py-2.5 transition-all duration-300
                                  hover:border-blue-300" />
                    <i id="eyeIcon"
                       class="fa-solid fa-eye-slash absolute right-4 top-3.5 cursor-pointer text-gray-500 hover:text-red-600 transition-colors"
                       style="display: none;"
                       onclick="togglePassword()">
                    </i>
                </div>
            </div>

            <!-- Bouton -->
            <div>
                <button type="submit" 
                        class="flex w-full justify-center items-center rounded-lg bg-red-600 px-6 py-3 
                               text-sm font-semibold text-white shadow-lg hover:bg-red-700 
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 
                               transition-all duration-300 transform hover:scale-105 active:scale-95
                               relative overflow-hidden group">
                    <span class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                    <i class="fa-solid fa-right-to-bracket mr-2 animate-bounce-slow"></i>
                    <span class="relative z-10">Se connecter</span>
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="absolute bottom-6 left-0 right-0 text-center animate-fade-in-delay-3">
            <p class="text-sm text-blue-800/60">
                <i class="fa-solid fa-heart text-red-500 mr-1"></i>
                &copy; 2025 CRTS Stock. Tous droits réservés.
            </p>
        </div>
    </div>

    <!-- Affichage du message d'erreur avec SweetAlert -->
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur de connexion',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- Script affichage/masquage mot de passe -->
    <script>
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        function togglePassword() {
            const isHidden = passwordInput.type === "password";
            passwordInput.type = isHidden ? "text" : "password";
            eyeIcon.className = isHidden 
                ? "fa-solid fa-eye absolute right-4 top-3.5 cursor-pointer text-red-600 hover:text-red-700 transition-colors" 
                : "fa-solid fa-eye-slash absolute right-4 top-3.5 cursor-pointer text-gray-500 hover:text-red-600 transition-colors";
        }

        function handleInput() {
            if (passwordInput.value.length > 0) {
                eyeIcon.style.display = "inline";
            } else {
                eyeIcon.style.display = "none";
                passwordInput.type = "password";
                eyeIcon.className = "fa-solid fa-eye-slash absolute right-4 top-3.5 cursor-pointer text-gray-500 hover:text-red-600 transition-colors";
            }
        }
    </script>

    <!-- Styles personnalisés pour les animations -->
    <style>
        @keyframes slideFromLeft {
            from { 
                opacity: 0; 
                transform: translateX(-100%) scale(0.8);
            }
            to { 
                opacity: 1; 
                transform: translateX(0) scale(1);
            }
        }
        @keyframes fadeInDelay1 {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDelay2 {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDelay3 {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes pulseSlow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes bounceSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }
        @keyframes ping {
            0% { transform: scale(1); opacity: 1; }
            70% { transform: scale(1.3); opacity: 0; }
            100% { transform: scale(1.3); opacity: 0; }
        }

        .animate-slide-from-left {
            animation: slideFromLeft 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .animate-fade-in-delay-1 {
            animation: fadeInDelay1 0.6s ease-out 0.2s forwards;
            opacity: 0;
        }
        .animate-fade-in-delay-2 {
            animation: fadeInDelay2 0.6s ease-out 0.4s forwards;
            opacity: 0;
        }
        .animate-fade-in-delay-3 {
            animation: fadeInDelay3 0.6s ease-out 0.6s forwards;
            opacity: 0;
        }
        .animate-pulse-slow {
            animation: pulseSlow 3s ease-in-out infinite;
        }
        .animate-bounce-slow {
            animation: bounceSlow 2s ease-in-out infinite;
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
        .animate-ping {
            animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
    </style>

</body>
</html>