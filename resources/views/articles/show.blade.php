@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Détails de l'Alerte Produit</h1>

    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Informations sur l'alerte</h2>

        <ul class="mb-6">
            <li><strong>ID de l'Alerte :</strong> {{ $alerte->alerteProd_id }}</li>
            <li><strong>Type d'alerte :</strong> {{ $alerte->typealerte }}</li>
            <li><strong>Date de déclenchement :</strong> {{ $alerte->datedeclenchement ? $alerte->datedeclenchement->format('d/m/Y H:i') : 'Non définie' }}</li>
        </ul>

        @if($alerte->produit)
        <h2 class="text-xl font-semibold mb-4">Informations sur le produit lié</h2>
        <ul>
            <li><strong>Code Produit :</strong> {{ $alerte->produit->codeproduit }}</li>
            <li><strong>Libellé :</strong> {{ $alerte->produit->libelle }}</li>
            <li><strong>Conditionnement :</strong> {{ $alerte->produit->conditionnement }}</li>
            <li><strong>Stock actuel :</strong> {{ $alerte->produit->quantitestock }}</li>
            <li><strong>Stock de sécurité :</strong> {{ $alerte->produit->stocksecurite }}</li>
            <li><strong>Date de péremption :</strong> {{ $alerte->produit->dateperemption }}</li>
            <li><strong>Lot :</strong> {{ $alerte->produit->lot }}</li>
        </ul>
        @else
        <div class="text-red-600 font-semibold">
            ⚠️ Aucun produit lié à cette alerte.
        </div>
