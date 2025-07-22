<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Détails de l'article</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>Code :</strong> {{ $article->codeproduit }}</li>
        <li class="list-group-item"><strong>Libellé :</strong> {{ $article->libelle }}</li>
        <li class="list-group-item"><strong>Conditionnement :</strong> {{ $article->conditionnement }}</li>
        <li class="list-group-item"><strong>Quantité en stock :</strong> {{ $article->quantitestock }}</li>
        <li class="list-group-item"><strong>Stock max :</strong> {{ $article->stockmax }}</li>
        <li class="list-group-item"><strong>Stock min :</strong> {{ $article->stockmin }}</li>
        <li class="list-group-item"><strong>Stock sécurité :</strong> {{ $article->stocksecurite }}</li>
        <li class="list-group-item"><strong>Date péremption :</strong> {{ $article->dateperemption }}</li>
        <li class="list-group-item"><strong>Lot :</strong> {{ $article->lot }}</li>
    </ul>

    <a href="{{ route('articles.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>

</body>
</html>
