<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ajout de mouvement</title>
</head>

<body>

    <h2>Ajouter un mouvement</h2>

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(auth()->user()->can('mouvements-create'))
        <form action="{{ route('mouvements.store') }}" method="POST">
            @csrf

            <label for="produit_id">Produit :</label>
            <select name="produit_id" id="produit_id" required>
                <option value="">-- Sélectionner un produit --</option>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->produit_id }}" @if (old('produit_id') == $produit->produit_id) selected @endif>
                        {{ $produit->libelle }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('produits.create') }}" target="_blank">Ajouter un produit</a>
            <p><em>Si le produit n’apparaît pas, créez-le puis actualisez cette page.</em></p>

            <label for="origine">Origine :</label>
            <input type="text" name="origine" id="origine" value="{{ old('origine') }}" required />

            <label for="quantite_commandee">Quantité commandée :</label>
            <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" required value="{{ old('quantite_commandee') }}" />

            <label for="quantite_entree">Quantité entrée :</label>
            <input type="number" name="quantite_entree" id="quantite_entree" min="0" value="{{ old('quantite_entree') }}" />

            <label for="quantite_sortie">Quantité sortie :</label>
            <input type="number" name="quantite_sortie" id="quantite_sortie" min="0" value="{{ old('quantite_sortie') }}" />

            <label for="stock_debut_mois">Stock début du mois :</label>
            <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="0" required value="{{ old('stock_debut_mois') }}" />

            <label for="avarie">Avarie :</label>
            <input type="number" name="avarie" id="avarie" min="0" value="{{ old('avarie') }}" />

            <label for="observation">Observation :</label>
            <textarea name="observation" id="observation">{{ old('observation') }}</textarea>

            <button type="submit">Créer</button>
        </form>
    @else
        <p>Vous n'avez pas la permission de créer des mouvements.</p>
    @endif

    <hr />

    <h3>Liste des mouvements déjà créés</h3>

    @if ($mouvements->count())
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Date</th>
                    <th>Origine</th>
                    <th>Quantité commandée</th>
                    <th>Quantité entrée</th>
                    <th>Quantité sortie</th>
                    <th>Avarie</th>
                    <th>Stock du jour</th>
                    <th>Observation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mouvements as $mouvement)
                    <tr>
                        <td>{{ $mouvement->produit->libelle ?? 'N/A' }}</td>
                        <td>{{ $mouvement->date }}</td>
                        <td>{{ $mouvement->origine }}</td>
                        <td>{{ $mouvement->quantite_commandee }}</td>
                        <td>{{ $mouvement->quantite_entree }}</td>
                        <td>{{ $mouvement->quantite_sortie }}</td>
                        <td>{{ $mouvement->avarie }}</td>
                        <td>{{ $mouvement->stock_jour }}</td>
                        <td>{{ $mouvement->observation }}</td>
                        <td>
                            @if(auth()->user()->can('mouvements-edit'))
                                <a href="{{ route('mouvements.edit', $mouvement->mouvement_id) }}">Modifier</a> |
                            @endif
                            @if(auth()->user()->can('mouvements-delete'))
                                <form action="{{ route('mouvements.destroy', $mouvement->mouvement_id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun mouvement enregistré pour le moment.</p>
    @endif

</body>

</html>

