<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
</head>

<body>

    <h2>Liste des produits dans la base</h2>

    <a href="{{ route('produits.create') }}">Ajouter un produit</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($produits->isEmpty())
        <p>Aucun produit enregistré pour le moment.</p>
    @else
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Conditionnement</th>
                    <th>Qté</th>
                    <th>Stock max</th>
                    <th>Stock min</th>
                    <th>Stock sécurité</th>
                    <th>Date péremption</th>
                    <th>Lot</th>
                    <th>Auteur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produits as $produit)
                    <tr>
                        <td>{{ $produit->codeproduit }}</td>
                        <td>{{ $produit->libelle }}</td>
                        <td>{{ $produit->conditionnement }}</td>
                        <td>{{ $produit->quantitestock }}</td>
                        <td>{{ $produit->stockmax }}</td>
                        <td>{{ $produit->stockmin }}</td>
                        <td>{{ $produit->stocksecurite }}</td>
                        <td>{{ $produit->dateperemption }}</td>
                        <td>{{ $produit->lot }}</td>
                        <td>{{ $produit->user->nom ?? 'Inconnu' }}</td>
                        <td>
                            <!-- Voir -->
                            <a href="{{ route('produits.show', $produit->produit_id) }}">
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007
                       9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5
                       12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </a>

                            <!-- Modifier -->
                            <a href="{{ route('produits.edit', $produit->produit_id) }}">
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1
                       2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897
                       1.13L6 18l.8-2.685a4.5 4.5 0 0 1
                       1.13-1.897l8.932-8.931Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0 1
                       15.75 21H5.25A2.25 2.25 0 0 1
                       3 18.75V8.25A2.25 2.25 0 0 1
                       5.25 6H10" />
                                    </svg>
                                </button>
                            </a>

                            <!-- Supprimer -->
                            <form action="{{ route('produits.destroy', $produit->produit_id) }}" method="POST"
                                onsubmit="return confirm('Supprimer ce produit ?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107
                       1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0
                       1-2.244 2.077H8.084a2.25 2.25 0 0
                       1-2.244-2.077L4.772 5.79m14.456 0a48.108
                       48.108 0 0 0-3.478-.397m-12
                       .562c.34-.059.68-.114 1.022-.165m0
                       0a48.11 48.11 0 0 1 3.478-.397m7.5
                       0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964
                       51.964 0 0 0-3.32 0c-1.18.037-2.09
                       1.022-2.09 2.201v.916m7.5 0a48.667
                       48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                            <br>
                            <a href="{{ route('mouvements-produits.create', ['produit' => $produit->produit_id]) }}">
                                <button type="button" title="Enregistrer un mouvement">
                                    📦 Mouvement
                                </button>
                            </a>


                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>

</html>
