@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto mt-8 bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
    <div class="flex items-center mb-8 pb-4 border-b-2 border-red-600">
        <i class="fa-solid fa-circle-exclamation text-red-600 text-3xl mr-4"></i>
        <h2 class="text-3xl font-bold text-gray-900">Détails de l'Alerte Produit</h2>
    </div>

    <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-barcode text-red-500 mr-2"></i>
                    Code
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->codeproduit }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-tag text-blue-600 mr-2"></i>
                    Libellé
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->libelle }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-boxes-stacked text-green-600 mr-2"></i>
                    Conditionnement
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->conditionnement }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-cubes text-amber-600 mr-2"></i>
                    Stock actuel
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->quantitestock }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-arrow-up-wide-short text-blue-600 mr-2"></i>
                    Stock max
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->stockmax }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-arrow-down-wide-short text-red-600 mr-2"></i>
                    Stock min
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->stockmin }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-shield text-indigo-600 mr-2"></i>
                    Stock sécurité
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->stocksecurite }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-calendar-xmark text-red-600 mr-2"></i>
                    Date péremption
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->dateperemption }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3">
                <span class="font-medium text-gray-700 flex items-center">
                    <i class="fa-solid fa-hashtag text-purple-600 mr-2"></i>
                    Lot
                </span> 
                <span class="text-gray-900 font-semibold mt-2 sm:mt-0">{{ $produit->lot }}</span>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('produits.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>
</div>

@endsection