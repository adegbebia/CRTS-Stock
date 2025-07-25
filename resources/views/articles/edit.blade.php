<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un article</title>
</head>
<body>

<div class="container mt-5">
    <h2>Modifier l'article : {{ $article->libelle }}</h2>

    <form action="{{ route('articles.update', $article->article_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Code article</label>
            <input type="text" name="codearticle" class="form-control" value="{{ $article->codearticle }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label>Libellé</label>
            <input type="text" name="libelle" class="form-control" value="{{ $article->libelle }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label>Conditionnement</label>
            <input type="text" name="conditionnement" class="form-control" value="{{ $article->conditionnement }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label>Quantité en stock</label>
            <input type="number" name="quantitestock" class="form-control" value="{{ $article->quantitestock }}" required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Stock max</label>
            <input type="number" name="stockmax" class="form-control" value="{{ $article->stockmax }}" required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Stock min</label>
            <input type="number" name="stockmin" class="form-control" value="{{ $article->stockmin }}" required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Stock sécurité</label>
            <input type="number" name="stocksecurite" class="form-control" value="{{ $article->stocksecurite }}" required min="0" title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label>Date de péremption</label>
            <input type="date" name="dateperemption" class="form-control" value="{{ $article->dateperemption }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" title="La date doit être ultérieure à aujourd'hui">
        </div>

        <div class="mb-3">
            <label>Lot</label>
            <input type="text" name="lot" class="form-control" value="{{ $article->lot }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

</body>
</html>
