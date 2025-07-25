<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
</head>
<body>

<div class="container mt-5">
    <h2>Modifier le produit : {{ $produit->libelle }}</h2>

    <form action="{{ route('produits.update', $produit->produit_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Code produit</label>
            <input type="text" name="codeproduit" class="form-control" value="{{ $produit->codeproduit }}"
                   required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label>Libellé</label>
            <input type="text" name="libelle" class="form-control" value="{{ $produit->libelle }}"
                   required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label>Conditionnement</label>
            <input type="text" name="conditionnement" class="form-control" value="{{ $produit->conditionnement }}"
                   required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label>Quantité en stock</label>
            <input type="number" name="quantitestock" class="form-control" value="{{ $produit->quantitestock }}"
                   required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Stock max</label>
            <input type="number" name="stockmax" class="form-control" value="{{ $produit->stockmax }}"
                   required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Stock min</label>
            <input type="number" name="stockmin" class="form-control" value="{{ $produit->stockmin }}"
                   required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Stock sécurité</label>
            <input type="number" name="stocksecurite" class="form-control" value="{{ $produit->stocksecurite }}"
                   required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Date de péremption</label>
            <input type="date" name="dateperemption" class="form-control" value="{{ $produit->dateperemption }}"
                   required min="{{ date('Y-m-d', strtotime('+1 day')) }}" title="La date doit être ultérieure à aujourd'hui">
        </div>

        <div class="mb-3">
            <label>Lot</label>
            <input type="text" name="lot" class="form-control" value="{{ $produit->lot }}"
                   required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

</body>
</html>