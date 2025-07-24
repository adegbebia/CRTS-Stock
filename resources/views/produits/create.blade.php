<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Produit</title>
</head>
<body>

    <h2>Ajouter / Créer un nouveau produit</h2>


    <form action="{{ route('produits.store') }}" method="POST">
        @csrf

        <div>
            <label for="codeproduit">Code Produit</label>
            <input type="text" name="codeproduit" id="codeproduit" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :" value="{{ old('codeproduit') }}">
            @error('codeproduit')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="libelle">Libellé</label>
            <input type="text" name="libelle" id="libelle" required pattern="[^,;:]+" value="{{ old('libelle') }}">
            @error('libelle')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="conditionnement">Conditionnement</label>
            <input type="text" name="conditionnement" id="conditionnement" required pattern="[^,;:]+" value="{{ old('conditionnement') }}">
            @error('conditionnement')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="quantitestock">Quantité</label>
            <input type="number" name="quantitestock" id="quantitestock" min="1" required value="{{ old('quantitestock') }}">
            @error('quantitestock')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="stockmax">Stock maximum</label>
            <input type="number" name="stockmax" id="stockmax" min="1" required value="{{ old('stockmax') }}">
            @error('stockmax')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="stockmin">Stock minimum</label>
            <input type="number" name="stockmin" id="stockmin" min="1" required value="{{ old('stockmin') }}">
            @error('stockmin')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="stocksecurite">Stock de sécurité</label>
            <input type="number" name="stocksecurite" id="stocksecurite" min="1" required value="{{ old('stocksecurite') }}">
            @error('stocksecurite')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="dateperemption">Date de péremption</label>
            <input type="date" name="dateperemption" id="dateperemption" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('dateperemption') }}">
            @error('dateperemption')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="lot">Lot</label>
            <input type="text" name="lot" id="lot" required pattern="[^,;:]+" value="{{ old('lot') }}">
            @error('lot')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
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
        </div>

        <br>
        <button type="submit">Enregistrer</button>
    </form>

    <br>
    <a href="{{ route('produits.index') }}">← Retour à la liste des produits</a><br>
    <a href="{{ route('mouvements-produits.create')}}">→ Enregistrer un mouvement</a>

</body>
</html>
