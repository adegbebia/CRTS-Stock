<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
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

    <form action="{{ route('mouvements-articles.store') }}" method="POST">
        @csrf

        @if ($articleSelectionne)
            @php
                $article = $articles->find($articleSelectionne);
            @endphp
            <p>Article sélectionné : <strong>{{ $article->libelle ?? 'N/A' }}</strong></p>
            <input type="hidden" name="article_id" value="{{ $articleSelectionne }}">
        @else
            <label for="article_id">Article</label>
            <select name="article_id" id="article_id" required>
                <option value="">-- Sélectionner un article --</option>
                @foreach ($articles as $article)
                    <option value="{{ $article->article_id }}" @if (old('article_id') == $article->article_id) selected @endif>
                        {{ $article->libelle }}
                    </option>
                @endforeach
            </select>
        @endif

        <a href="{{ route('articles.create') }}" target="_blank">Ajouter un article</a>
        <p><em>Si l'article n’apparaît pas, créez-le puis actualisez cette page.</em></p>

        <label for="origine">Origine</label>
        <input type="text" name="origine" id="origine" value="{{ old('origine') }}" />

        <label for="quantite_commandee">Quantité commandée</label>
        <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" required value="{{ old('quantite_commandee') }}" />

        <label for="quantite_entree">Quantité entrée</label>
        <input type="number" name="quantite_entree" id="quantite_entree" min="1" value="{{ old('quantite_entree') }}" />

        <label for="quantite_sortie">Quantité sortie</label>
        <input type="number" name="quantite_sortie" id="quantite_sortie" min="1" value="{{ old('quantite_sortie') }}" />

        <label for="stock_debut_mois">Stock début du mois</label>
        <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="1" required value="{{ old('stock_debut_mois') }}" />

        <label for="avarie">Avarie</label>
        <input type="number" name="avarie" id="avarie" min="1" value="{{ old('avarie') }}" />

        <label for="observation">Observation</label>
        <textarea name="observation" id="observation">{{ old('observation') }}</textarea>

        <button type="submit">Créer</button>
    </form>

    <hr />

    <h3>Liste des mouvements déjà créés</h3>

    @if ($mouvements->count())
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Article</th>
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
                        <td>{{ $mouvement->article->libelle ?? 'N/A' }}</td>
                        <td>{{ $mouvement->date }}</td>
                        <td>{{ $mouvement->origine }}</td>
                        <td>{{ $mouvement->quantite_commandee }}</td>
                        <td>{{ $mouvement->quantite_entree }}</td>
                        <td>{{ $mouvement->quantite_sortie }}</td>
                        <td>{{ $mouvement->avarie }}</td>
                        <td>{{ $mouvement->stock_jour }}</td>
                        <td>{{ $mouvement->observation }}</td>
                        <td>
                            <a href="{{ route('mouvements-articles.edit', $mouvement->mouvementProd_id) }}">Modifier</a>
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
