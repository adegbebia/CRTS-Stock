<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

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

</body>
</html>

@extends('layouts.app')

@section('title', 'Dashboard - Alertes')

@section('content')

@endsection

