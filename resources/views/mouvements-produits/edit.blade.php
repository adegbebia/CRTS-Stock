<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un mouvement</title>
</head>
<body>

    <h2>Modifier le mouvement</h2>

    {{-- @if ($errors->any())
        <div style="color: red;">
            <strong>Veuillez corriger les erreurs ci-dessous :</strong>
        </div>
    @endif --}}

    <form action="{{ route('mouvements-produits.update', ['mouvements_produit' => $mouvement->mouvementProd_id]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Produit -->
        <div>
            <label for="produit_id">Article</label>
            <select name="produit_id" id="produit_id" required>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->produit_id }}"
                        {{ old('produit_id', $mouvement->produit_id) == $produit->produit_id ? 'selected' : '' }}>
                        {{ $produit->libelle }}
                    </option>
                @endforeach
            </select>
            @error('produit_id')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Origine -->
        <div>
            <label for="origine">Origine</label>
            <input type="text" name="origine" id="origine" required pattern="[^,;:]+" 
                value="{{ old('origine', $mouvement->origine) }}"
                title="Ne doit pas contenir les caractères , ; :">
            @error('origine')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantité commandée -->
        <div>
            <label for="quantite_commandee">Quantité commandée</label>
            <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" required
                value="{{ old('quantite_commandee', $mouvement->quantite_commandee) }}">
            @error('quantite_commandee')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantité entrée -->
        <div>
            <label for="quantite_entree">Quantité entrée</label>
            <input type="number" name="quantite_entree" id="quantite_entree" min="0"
                value="{{ old('quantite_entree', $mouvement->quantite_entree) }}">
            @error('quantite_entree')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantité sortie -->
        <div>
            <label for="quantite_sortie">Quantité sortie</label>
            <input type="number" name="quantite_sortie" id="quantite_sortie" min="0"
                value="{{ old('quantite_sortie', $mouvement->quantite_sortie) }}">
            @error('quantite_sortie')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stock début du mois -->
        <div>
            <label for="stock_debut_mois">Stock début du mois</label>
            <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="0" required
                value="{{ old('stock_debut_mois', $mouvement->stock_debut_mois) }}">
            @error('stock_debut_mois')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Avarie -->
        <div>
            <label for="avarie">Avarie</label>
            <input type="number" name="avarie" id="avarie" min="0"
                value="{{ old('avarie', $mouvement->avarie) }}">
            @error('avarie')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Observation -->
        <div>
            <label for="observation">Observation</label>
            <textarea name="observation" id="observation">{{ old('observation', $mouvement->observation) }}</textarea>
            @error('observation')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Bouton de soumission -->
        <div>
            <button type="submit">Mettre à jour</button>
        </div>

    </form>

</body>
</html>
