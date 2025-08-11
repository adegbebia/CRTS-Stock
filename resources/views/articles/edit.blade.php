@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Modifier l'article : {{ $article->libelle }}</h2>

    <form action="{{ route('articles.update', $article->article_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="codearticle" class="form-label">Code article</label>
            <input 
                type="text" 
                id="codearticle" 
                name="codearticle" 
                class="form-control" 
                value="{{ old('codearticle', $article->codearticle) }}" 
                required 
                pattern="[^,;:]+" 
                title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label for="libelle" class="form-label">Libellé</label>
            <input 
                type="text" 
                id="libelle" 
                name="libelle" 
                class="form-control" 
                value="{{ old('libelle', $article->libelle) }}" 
                required 
                pattern="[^,;:]+" 
                title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label for="conditionnement" class="form-label">Conditionnement</label>
            <input 
                type="text" 
                id="conditionnement" 
                name="conditionnement" 
                class="form-control" 
                value="{{ old('conditionnement', $article->conditionnement) }}" 
                required 
                pattern="[^,;:]+" 
                title="Ne doit pas contenir les caractères , ; :">
        </div>

        <div class="mb-3">
            <label for="quantitestock" class="form-label">Quantité en stock</label>
            <input 
                type="number" 
                id="quantitestock" 
                name="quantitestock" 
                class="form-control" 
                value="{{ old('quantitestock', $article->quantitestock) }}" 
                required 
                min="0" 
                title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label for="stockmax" class="form-label">Stock max</label>
            <input 
                type="number" 
                id="stockmax" 
                name="stockmax" 
                class="form-control" 
                value="{{ old('stockmax', $article->stockmax) }}" 
                required 
                min="0" 
                title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label for="stockmin" class="form-label">Stock min</label>
            <input 
                type="number" 
                id="stockmin" 
                name="stockmin" 
                class="form-control" 
                value="{{ old('stockmin', $article->stockmin) }}" 
                required 
                min="0" 
                title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label for="stocksecurite" class="form-label">Stock sécurité</label>
            <input 
                type="number" 
                id="stocksecurite" 
                name="stocksecurite" 
                class="form-control" 
                value="{{ old('stocksecurite', $article->stocksecurite) }}" 
                required 
                min="0" 
                title="La valeur ne peut pas être négative">
        </div>

        <div class="mb-3">
            <label for="dateperemption" class="form-label">Date de péremption</label>
            <input 
                type="date" 
                id="dateperemption" 
                name="dateperemption" 
                class="form-control" 
                value="{{ old('dateperemption', $article->dateperemption) }}" 
                required 
                min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                title="La date doit être ultérieure à aujourd'hui">
        </div>

        <div class="mb-3">
            <label for="lot" class="form-label">Lot</label>
            <input 
                type="text" 
                id="lot" 
                name="lot" 
                class="form-control" 
                value="{{ old('lot', $article->lot) }}" 
                required 
                pattern="[^,;:]+" 
                title="Ne doit pas contenir les caractères , ; :">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
