<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <h2>Connexion</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">E-mail</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus><br><br>

        <label for="password">Mot de passe</label><br>
        <input type="password" id="password" name="password" required oninput="handleInput()">
        <i
            id="eyeIcon"
            class="fa-solid fa-eye-slash"
            onclick="togglePassword()"
            style="cursor: pointer; display: none;"
        ></i><br><br>

        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Se souvenir de moi</label><br><br>

        <button type="submit">Se connecter</button>
    </form>

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
            eyeIcon.className = isHidden ? "fa-solid fa-eye" : "fa-solid fa-eye-slash";
        }

        function handleInput() {
            if (passwordInput.value.length > 0) {
                eyeIcon.style.display = "inline";
            } else {
                eyeIcon.style.display = "none";
                passwordInput.type = "password"; // cacher quand vide
                eyeIcon.className = "fa-solid fa-eye-slash";
            }
        }
    </script>

</body>
</html>
