<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails utilisateur</title>
</head>
<body>
    <h1>Détails de l'utilisateur</h1>

    <!-- <p><strong>ID :</strong> {{ $user->user_id }}</p> -->
    <p><strong>Nom :</strong> {{ $user->nom }}</p>
    <p><strong>Prénom :</strong> {{ $user->prenom }}</p>
    <p><strong>Adresse :</strong> {{ $user->adresse }}</p>
    <p><strong>Téléphone :</strong> {{ $user->telephone }}</p>
    <p><strong>Magasin affecté :</strong> {{ ucfirst($user->magasin_affecte) }}</p>
    <p><strong>Email :</strong> {{ $user->email }}</p>



    <a href="{{ route('users.edit', $user->user_id) }}">Modifier</a>
    <a href="{{ route('users.index') }}">Retour à la liste</a>
</body>
</html>
