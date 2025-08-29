<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion - CRTS Stock</title>

    {{-- Tailwind & JS compilés avec Vite --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- Font Awesome (optionnel, si tu veux en local via npm je peux te configurer) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-red-400 via-white to-blue-400 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8 space-y-6">
        <!-- Logo + Titre -->
        <div class="text-center">
            <img src="{{ asset('images/logo-crts.png') }}" 
                 alt="Logo CRTS" 
                 class="mx-auto h-20 w-20 rounded-full shadow-md border border-gray-200 bg-white p-2" />

            <h1 class="mt-4 text-3xl font-extrabold text-indigo-700">
                Bienvenue sur <span class="text-indigo-900">CRTS Stock</span>
            </h1>
            <p class="mt-2 text-gray-600">Veuillez vous connecter pour accéder à votre espace</p>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Affichage erreur simple -->
            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Nom Pseudo -->
            <div>
                <label for="nom_pseudo" class="block text-sm font-medium text-gray-700">Nom Pseudo</label>
                <input id="nom_pseudo" 
                       name="nom_pseudo"
                       required
                       placeholder="Entrez votre identifiant"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 
                              focus:ring-indigo-500 sm:text-sm px-3 py-2 border" />
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <div class="relative mt-1">
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           oninput="handleInput()"
                           placeholder="••••••••"
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 
                                  focus:ring-indigo-500 sm:text-sm px-3 py-2 border" />
                    <i id="eyeIcon"
                       class="fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500"
                       style="display: none;"
                       onclick="togglePassword()">
                    </i>
                </div>
            </div>

            <!-- Bouton -->
            <div>
                <button type="submit" 
                        class="flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 
                               text-sm font-semibold text-white shadow-md hover:bg-indigo-500 
                               focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-600 transition">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Se connecter
                </button>
            </div>
        </form>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            &copy; 2025 CRTS Stock. Tous droits réservés.
        </p>
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
                ? "fa-solid fa-eye absolute right-3 top-3 cursor-pointer text-gray-500" 
                : "fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500";
        }

        function handleInput() {
            if (passwordInput.value.length > 0) {
                eyeIcon.style.display = "inline";
            } else {
                eyeIcon.style.display = "none";
                passwordInput.type = "password";
                eyeIcon.className = "fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500";
            }
        }
    </script>

</body>
</html>
