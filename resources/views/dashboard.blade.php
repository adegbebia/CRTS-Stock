<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Alertes</title>
</head>
<body>

<h1>Liste des alertes</h1>

@if($alertes->count())
    <ul>
        @foreach($alertes as $alerte)
            <li>
                [{{ $alerte->datedeclenchement }}] 
                Produit : {{ $alerte->produit->libelle ?? 'Produit supprimé' }} - 
                Type d'alerte : {{ $alerte->typealerte }}
            </li>
        @endforeach
    </ul>
@else
    <p>Aucune alerte pour le moment.</p>
@endif

</body>
</html>
