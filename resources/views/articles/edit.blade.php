@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Modifier l'article : {{ $article->libelle }}</h2>

    <form action="{{ route('articles.update', $article->article_id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="codearticle" class="block mb-1 font-medium text-gray-700">Code article</label>
            <input type="text" id="codearticle" name="codearticle" value="{{ old('codearticle', $article->codearticle) }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="libelle" class="block mb-1 font-medium text-gray-700">Libellé</label>
            <input type="text" id="libelle" name="libelle" value="{{ old('libelle', $article->libelle) }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="conditionnement" class="block mb-1 font-medium text-gray-700">Conditionnement</label>
            <input type="text" id="conditionnement" name="conditionnement" value="{{ old('conditionnement', $article->conditionnement) }}" required pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="quantitestock" class="block mb-1 font-medium text-gray-700">Quantité en stock</label>
            <input type="number" id="quantitestock" name="quantitestock" value="{{ old('quantitestock', $article->quantitestock) }}" required min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                onwheel="event.preventDefault()" />
        </div>

        <div>
            <label for="stockmax" class="block mb-1 font-medium text-gray-700">Stock max</label>
            <input type="number" id="stockmax" name="stockmax" value="{{ old('stockmax', $article->stockmax) }}"  min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                onwheel="event.preventDefault()" />
        </div>

        <div>
            <label for="stockmin" class="block mb-1 font-medium text-gray-700">Stock min</label>
            <input type="number" id="stockmin" name="stockmin" value="{{ old('stockmin', $article->stockmin) }}"  min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                onwheel="event.preventDefault()" />
        </div>

        <div>
            <label for="stocksecurite" class="block mb-1 font-medium text-gray-700">Stock sécurité</label>
            <input type="number" id="stocksecurite" name="stocksecurite" value="{{ old('stocksecurite', $article->stocksecurite) }}" required min="0" title="La valeur ne peut pas être négative"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                onwheel="event.preventDefault()" />
        </div>

        <div>
            <label for="dateperemption" class="block mb-1 font-medium text-gray-700">Date de péremption</label>
            <input type="date" id="dateperemption" name="dateperemption" value="{{ old('dateperemption', $article->dateperemption) }}"  min="{{ date('Y-m-d', strtotime('+1 day')) }}" title="La date doit être ultérieure à aujourd'hui"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
        </div>

        <div>
            <label for="lot" class="block mb-1 font-medium text-gray-700">Lot</label>
            <input type="text" id="lot" name="lot" value="{{ old('lot', $article->lot) }}"  pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :"
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
