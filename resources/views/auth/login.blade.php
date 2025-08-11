<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50">

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm text-center">
            <img src="{{ asset('images/logo-crts.png') }}" 
                alt="Logo CRTS" 
                class="mx-auto h-16 w-auto rounded-full shadow-lg border border-gray-200 bg-white p-2" />

            <h2 class="mt-10 text-2xl font-bold tracking-tight text-gray-900">
                Se Connecter à Son Compte
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                @if(session('error'))
                    <div style="color: red">{{ session('error') }}</div>
                @endif

                <!-- Nom Pseudo -->
                <div>
                    <label for="nom_pseudo" class="block text-sm font-medium text-gray-900">Nom Pseudo</label>
                    <input id="nom_pseudo" 
                           name="nom_pseudo"
                           required
                           class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 
                                  outline outline-1 outline-gray-300 placeholder:text-gray-400 
                                  focus:outline-2 focus:outline-indigo-600 sm:text-sm" />
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">Mot de passe</label>
                    <div class="relative">
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               oninput="handleInput()"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 
                                      outline outline-1 outline-gray-300 placeholder:text-gray-400 
                                      focus:outline-2 focus:outline-indigo-600 sm:text-sm" />
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
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 
                                   text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 
                                   focus-visible:outline focus-visible:outline-2 
                                   focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Affichage du message d'erreur avec SweetAlert -->
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script>
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        function togglePassword() {
            const isHidden = passwordInput.type === "password";
            passwordInput.type = isHidden ? "text" : "password";
            eyeIcon.className = isHidden ? "fa-solid fa-eye absolute right-3 top-3 cursor-pointer text-gray-500" 
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
