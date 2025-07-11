<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreationProduit</title>
</head>
<body>
    
    <div class="container mt-5">
        <h2>Ajouter/Crée un nouveau produit</h2>

        {{-- Affichage des erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulaire --}}
        <form action="{{ route('produits.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="codeproduit" class="form-label">Code Produit</label>
                <input type="text" name="codeproduit" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="libelle" class="form-label">Libellé</label>
                <input type="text" name="libelle" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="conditionnement" class="form-label">Conditionnement</label>
                <input type="text" name="conditionnement" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="quantitestock" class="form-label">Quantité en stock</label>
                <input type="number" name="quantitestock" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stockmax" class="form-label">Stock maximum</label>
                <input type="number" name="stockmax" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stockmin" class="form-label">Stock minimum</label>
                <input type="number" name="stockmin" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stocksecurite" class="form-label">Stock de sécurité</label>
                <input type="number" name="stocksecurite" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="dateperemption" class="form-label">Date de péremption</label>
                <input type="date" name="dateperemption" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="lot" class="form-label">Lot</label>
                <input type="text" name="lot" class="form-control" required>
            </div>

            <!-- <div class="mb-3">
                <label for="user_id" class="form-label">Utilisateur (ID)</label>
                <input type="number" name="user_id" class="form-control" required>
            </div> -->

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>


</body>
</html>