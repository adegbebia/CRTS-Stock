@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2>Détails du produit</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>Code :</strong> {{ $produit->codeproduit }}</li>
        <li class="list-group-item"><strong>Libellé :</strong> {{ $produit->libelle }}</li>
        <li class="list-group-item"><strong>Conditionnement :</strong> {{ $produit->conditionnement }}</li>
        <li class="list-group-item"><strong>Quantité en stock :</strong> {{ $produit->quantitestock }}</li>
        <li class="list-group-item"><strong>Stock max :</strong> {{ $produit->stockmax }}</li>
        <li class="list-group-item"><strong>Stock min :</strong> {{ $produit->stockmin }}</li>
        <li class="list-group-item"><strong>Stock sécurité :</strong> {{ $produit->stocksecurite }}</li>
        <li class="list-group-item"><strong>Date péremption :</strong> {{ $produit->dateperemption }}</li>
        <li class="list-group-item"><strong>Lot :</strong> {{ $produit->lot }}</li>
    </ul>

    <a href="{{ route('produits.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>

@endsection