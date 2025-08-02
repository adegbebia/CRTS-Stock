<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur</title>
</head>
<body>
    <h1>Créer un utilisateur</h1>

    @php
        $user = auth()->user();
    @endphp

    @if ($user && $user->hasRole('admin'))

        @if ($errors->any())
            <div>
                <ul style="color:red;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <label for="nom">Nom :</label><br>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"><br><br>

            <label for="prenom">Prénom :</label><br>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"><br><br>

            <label for="adresse">Adresse :</label><br>
            <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"><br><br>

            <label for="telephone">Téléphone :</label><br>
            <input type="tel" name="telephone" id="telephone" pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$"
            maxlength="8"
            required
            value="{{ old('telephone', isset($user) ? $user->telephone : '') }}"
            title="Numéro togolais valide : commence par 70 à 79 ou 90 à 99, et contient exactement 8 chiffres."><br><br>

            <label for="magasin_affecte">Magasin affecté :</label><br>
            <select name="magasin_affecte" id="magasin_affecte" required>
                <option value="">-- Choisir un magasin ou role--</option>
                <option value="collation" {{ old('magasin_affecte') == 'collation' ? 'selected' : '' }}>Collation</option>
                <option value="technique" {{ old('magasin_affecte') == 'technique' ? 'selected' : '' }}>Technique</option>
                <option value="admin"     {{ old('magasin_affecte') == 'admin' ? 'selected' : '' }}>Admin</option>

            </select><br><br>

            <label for="email">Email :</label><br>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"><br><br>

            <label for="password">Mot de passe :</label><br>
            <input type="password" name="password" id="password"><br><br>

            <label for="password_confirmation">Confirmer mot de passe :</label><br>
            <input type="password" name="password_confirmation" id="password_confirmation"><br><br>

            <button type="submit">Créer</button>
        </form>

        <br>
        <a href="{{ route('users.index') }}">Retour à la liste</a>

    @else
        <p style="color:red;">Vous n'êtes pas autorisé à accéder à cette page.</p>
        <a href="{{ route('users.index') }}">Retour</a>
    @endif

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                swal("Succès", "{{ session('success') }}", "success");
            });
        </script>
    @endif

    @if($errors->has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                swal("Erreur", "{{ $errors->first('error') }}", "error");
            });
        </script>
    @endif

</body>
</html>
