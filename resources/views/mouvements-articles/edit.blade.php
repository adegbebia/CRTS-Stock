<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un mouvement</title>
</head>
<body>

    <h2>Modifier le mouvement</h2>

    <form action="{{ route('mouvements-articles.update', $mouvement->mouvement_id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="article_id">Article</label>
        <select name="article_id" id="article_id" required>
            @foreach ($articles as $article)
                <option value="{{ $article->article_id }}" {{ $mouvement->article_id == $article->article_id ? 'selected' : '' }}>
                    {{ $article->libelle }}
                </option>
            @endforeach
        </select>

        <label for="origine">Origine</label>
        <input type="text" name="origine" id="origine" value="{{ old('origine', $mouvement->origine) }}">

        <label for="quantite_commandee">Quantité commandée</label>
        <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" value="{{ old('quantite_commandee', $mouvement->quantite_commandee) }}" required>

        <label for="quantite_entree">Quantité entrée</label>
        <input type="number" name="quantite_entree" id="quantite_entree" min="1" value="{{ old('quantite_entree', $mouvement->quantite_entree) }}">

        <label for="quantite_sortie">Quantité sortie</label>
        <input type="number" name="quantite_sortie" id="quantite_sortie" min="1" value="{{ old('quantite_sortie', $mouvement->quantite_sortie) }}">

        <label for="stock_debut_mois">Stock début du mois</label>
        <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="1" value="{{ old('stock_debut_mois', $mouvement->stock_debut_mois) }}" required>

        <label for="avarie">Avarie</label>
        <input type="number" name="avarie" id="avarie" min="1" value="{{ old('avarie', $mouvement->avarie) }}">

        <label for="observation">Observation</label>
        <textarea name="observation" id="observation">{{ old('observation', $mouvement->observation) }}</textarea>

        <button type="submit">Mettre à jour</button>
    </form>

</body>
</html>
