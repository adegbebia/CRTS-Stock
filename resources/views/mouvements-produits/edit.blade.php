<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un mouvement</title>
</head>
<body>

    <h2>Modifier le mouvement</h2>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mouvements-produits.update', ['mouvements_produit' => $mouvement->mouvementProd_id]) }}" method="POST">        @csrf
        @method('PUT')

        <!-- Sélection de l'article -->
        <label for="produit_id">Article</label>
        <select name="produit_id" id="produit_id" required>
            @foreach ($produits as $produit)
                <option value="{{ $produit->produit_id }}" {{ $mouvement->produit_id == $produit->produit_id ? 'selected' : '' }}>
                    {{ $produit->libelle }}
                </option>
            @endforeach
        </select>

        <!-- Origine -->
        <label for="origine">Origine</label>
        <input type="text" name="origine" id="origine" value="{{ old('origine', $mouvement->origine) }}">

        <!-- Quantité commandée -->
        <label for="quantite_commandee">Quantité commandée</label>
        <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" value="{{ old('quantite_commandee', $mouvement->quantite_commandee) }}" required>

        <!-- Quantité entrée -->
        <label for="quantite_entree">Quantité entrée</label>
        <input type="number" name="quantite_entree" id="quantite_entree" min="0" value="{{ old('quantite_entree', $mouvement->quantite_entree) }}">

        <!-- Quantité sortie -->
        <label for="quantite_sortie">Quantité sortie</label>
        <input type="number" name="quantite_sortie" id="quantite_sortie" min="0" value="{{ old('quantite_sortie', $mouvement->quantite_sortie) }}">

        <!-- Stock début du mois -->
        <label for="stock_debut_mois">Stock début du mois</label>
        <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="0" value="{{ old('stock_debut_mois', $mouvement->stock_debut_mois) }}" required>

        <!-- Avarie -->
        <label for="avarie">Avarie</label>
        <input type="number" name="avarie" id="avarie" min="0" value="{{ old('avarie', $mouvement->avarie) }}">

        <!-- Observation -->
        <label for="observation">Observation</label>
        <textarea name="observation" id="observation">{{ old('observation', $mouvement->observation) }}</textarea>

        <!-- Bouton de soumission -->
        <button type="submit">Mettre à jour</button>
    </form>

</body>
</html>
