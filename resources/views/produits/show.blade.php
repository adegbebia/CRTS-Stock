@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Détails de l'Alerte produit</h2>

    <ul class="divide-y divide-gray-200">
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Code :</span>
            <span class="text-gray-900">{{ $produit->codeproduit }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Libellé :</span>
            <span class="text-gray-900">{{ $produit->libelle }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Conditionnement :</span>
            <span class="text-gray-900">{{ $produit->conditionnement }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Stock actuel :</span>
            <span class="text-gray-900">{{ $produit->quantitestock }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Stock max :</span>
            <span class="text-gray-900">{{ $produit->stockmax }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Stock min :</span>
            <span class="text-gray-900">{{ $produit->stockmin }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Stock sécurité :</span>
            <span class="text-gray-900">{{ $produit->stocksecurite }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Date péremption :</span>
            <span class="text-gray-900">{{ $produit->dateperemption }}</span>
        </li>
        <li class="py-3 flex justify-between">
            <span class="font-medium text-gray-700">Lot :</span>
            <span class="text-gray-900">{{ $produit->lot }}</span>
        </li>
    </ul>

    <a href="{{ route('produits.index') }}"
       class="inline-block mt-6 px-4 py-2 bg-red-300 hover:bg-gray-700 text-white rounded transition duration-200">
        ← Retour
    </a>
</div>

@endsection
