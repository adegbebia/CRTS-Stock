@extends('layouts.app')



@section('content')

    <h1>Modifier un utilisateur</h1>

    @if (!auth()->user()->hasRole('admin'))
        <p style="color: red;">Accès refusé : vous n'avez pas les droits nécessaires pour modifier un utilisateur.</p>
        <a href="{{ route('users.index') }}">Retour à la liste</a>
    @else
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

            <label for="nom_pseudo">Nom Pseudo :</label><br>
            <input type="text" name="nom_pseudo" id="nom_pseudo"
                value="{{ old('nom_pseudo', $user->nom_pseudo) }}"><br><br>


            <label for="prenom">Prénom :</label><br>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"><br><br>

            <label for="adresse">Adresse :</label><br>
            <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->adresse) }}"><br><br>

            <label for="telephone">Téléphone :</label><br>
            <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $user->telephone ?? '') }}"
                pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$" maxlength="8"
                title="Numéro togolais valide : commence par 70 à 79 ou 90 à 99, et contient exactement 8 chiffres."
                required><br><br>

            <label for="magasin_affecte">Magasin affecté :</label><br>
            <select name="magasin_affecte" id="magasin_affecte" required>
                <option value="">-- Choisir un magasin --</option>
                <option value="collation"
                    {{ old('magasin_affecte', $user->magasin_affecte) == 'collation' ? 'selected' : '' }}>Collation</option>
                <option value="technique"
                    {{ old('magasin_affecte', $user->magasin_affecte) == 'technique' ? 'selected' : '' }}>Technique</option>
                <option value="admin" {{ old('magasin_affecte', $user->magasin_affecte) == 'admin' ? 'selected' : '' }}>
                    Admin</option>

            </select><br><br>

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

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal("Succès", "{{ session('success') }}", "success");
                });
            </script>
        @endif

        @if ($errors->has('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal("Erreur", "{{ $errors->first('error') }}", "error");
                });
            </script>
        @endif

    @endif

@endsection
