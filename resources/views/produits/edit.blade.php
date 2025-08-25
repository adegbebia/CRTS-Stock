@extends('layouts.app')

@section('title', 'modification produits')

@section('content')

<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Modifier le produit : {{ $produit->libelle }}</h2>

    <form action="{{ route('produits.update', $produit->produit_id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="codeproduit" class="block mb-1 font-medium text-gray-700">Code produit</label>
            <input type="text" id="codeproduit" name="codeproduit" value="{{ old('codeproduit', $produit->codeproduit) }}" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/\s]+$" 
                title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + ou espaces" 
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="libelle" class="block mb-1 font-medium text-gray-700">Libellé</label>
            <input type="text" name="libelle" id="libelle" value="{{ $produit->libelle }}" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/]+$"  
                title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > +"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="conditionnement" class="block mb-1 font-medium text-gray-700">Conditionnement</label>
            <input type="text" name="conditionnement" id="conditionnement" value="{{ $produit->conditionnement }}" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/]+$"  
                title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > +"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="quantitestock" class="block mb-1 font-medium text-gray-700">Quantité en stock</label>
            <input type="number" name="quantitestock" id="quantitestock" value="{{ $produit->quantitestock }}" required min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" 
                onwheel="event.preventDefault()"/>
        </div>

        <div>
            <label for="stockmax" class="block mb-1 font-medium text-gray-700">Stock max</label>
            <input type="number" name="stockmax" id="stockmax" value="{{ $produit->stockmax }}"  min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" 
                onwheel="event.preventDefault()"/>
        </div>

        <div>
            <label for="stockmin" class="block mb-1 font-medium text-gray-700">Stock min</label>
            <input type="number" name="stockmin" id="stockmin" value="{{ $produit->stockmin }}"  min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" 
                onwheel="event.preventDefault()"/>
        </div>

        <div>
            <label for="stocksecurite" class="block mb-1 font-medium text-gray-700">Stock sécurité</label>
            <input type="number" name="stocksecurite" id="stocksecurite" value="{{ $produit->stocksecurite }}" required min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" 
                onwheel="event.preventDefault()"/>
        </div>

        <div>
            <label for="dateperemption" class="block mb-1 font-medium text-gray-700">Date de péremption</label>
            <input type="date" name="dateperemption" id="dateperemption" value="{{ $produit->dateperemption }}"  min="{{ date('Y-m-d', strtotime('+1 day')) }}" title="La date doit être ultérieure à aujourd'hui"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="lot" class="block mb-1 font-medium text-gray-700">Lot</label>
            <input type="text" name="lot" id="lot" value="{{ $produit->lot }}"  pattern="^[^,;:\.?!=%@&()$*#^{}<>+/\s]+$" 
                title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + ou espaces" 
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full bg-red-300 hover:bg-red-600 text-white font-semibold py-3 rounded transition duration-200">
                Mettre à jour
            </button>
        </div>
    </form>
</div>

@endsection
