<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
</head>
<body>
    <h1>Modifier un utilisateur</h1>

    @if ($errors->any())
        <div>
            <ul style="color:red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}"><br><br>

        <label for="prenom">Prénom :</label><br>
        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"><br><br>

        <label for="adresse">Adresse :</label><br>
        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->adresse) }}"><br><br>

        <label for="telephone">Téléphone :</label><br>
        <input type="tel" name="telephone" id="telephone"
            value="{{ old('telephone', $user->telephone ?? '') }}"
            pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$"
            maxlength="8"
            title="Numéro togolais valide : commence par 70 à 79 ou 90 à 99, et contient exactement 8 chiffres."
            required><br><br>

        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" name="password" id="password"><br><br>

        <label for="password_confirmation">Confirmer mot de passe :</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation"><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <br>
    <a href="{{ route('users.index') }}">Retour à la liste</a>

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
