<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Produit</title>
</head>
<body>

    <h2>Ajouter / Créer un nouveau produit</h2>

    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire -->
    <form action="{{ route('produits.store') }}" method="POST">
        @csrf

        <label for="codeproduit">Code Produit</label>
        <input type="text" name="codeproduit" id="codeproduit" required pattern="[^,;]+"><br>

        <label for="libelle">Libellé</label>
        <input type="text" name="libelle" id="libelle" required pattern="[^,;]+"><br>

        <label for="conditionnement">Conditionnement</label>
        <input type="text" name="conditionnement" id="conditionnement" required pattern="[^,;]+"><br>

        <label for="quantitestock">Quantité en stock</label>
        <input type="number" name="quantitestock" id="quantitestock" min="0" required><br>

        <label for="stockmax">Stock maximum</label>
        <input type="number" name="stockmax" id="stockmax" min="0" required><br>

        <label for="stockmin">Stock minimum</label>
        <input type="number" name="stockmin" id="stockmin" min="0" required><br>

        <label for="stocksecurite">Stock de sécurité</label>
        <input type="number" name="stocksecurite" id="stocksecurite" min="0" required><br>

        <label for="dateperemption">Date de péremption</label>
        <input type="date" name="dateperemption" id="dateperemption" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"><br>

        <label for="lot">Lot</label>
        <input type="text" name="lot" id="lot" required pattern="[^,;]+"><br>

        <label for="user_id">Auteur</label>
        <select name="user_id" id="user_id" required>
            <option value="">Sélectionnez un auteur</option>
            @foreach($users as $user)
                <option value="{{ $user->user_id }}" @selected(old('user_id') == $user->user_id)>
                    {{ $user->nom }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <div style="color:red;">{{ $message }}</div>
        @enderror

        <br><br>
        <button type="submit">Enregistrer</button>
    </form>

    <br>
    <a href="{{ route('produits.index') }}">← Retour à la liste des produits</a><br>
    <a href="{{ route('mouvements.create') }}">→ Enregistrer un mouvement</a>

</body>
</html>
