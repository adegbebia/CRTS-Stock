<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Alertes</title>
</head>
<body>

<h1>Liste des alertes</h1>

<h2>Alertes Produits</h2>
@if($alertesProduits->count())
    <ul>
        @foreach($alertesProduits as $alerte)
            <li>
                [{{ $alerte->datedeclenchement }}] 
                Produit : {{ $alerte->produit->libelle ?? 'Produit supprimé' }} - 
                Type d'alerte : {{ $alerte->typealerte }}
            </li>
        @endforeach
    </ul>
@else
    <p>Aucune alerte produit pour le moment.</p>
@endif

<hr>

<h2>Alertes Articles</h2>
@if($alertesArticles->count())
    <ul>
        @foreach($alertesArticles as $alerte)
            <li>
                [{{ $alerte->datedeclenchement }}] 
                Article : {{ $alerte->article->libelle ?? 'Article supprimé' }} - 
                Type d'alerte : {{ $alerte->typealerte }}
            </li>
        @endforeach
    </ul>
@else
    <p>Aucune alerte article pour le moment.</p>
@endif

</body>
</html>
