@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
    <div class="flex items-center mb-8 pb-4 border-b border-gray-200">
        <i class="fa-solid fa-pen-to-square text-red-600 text-3xl mr-4"></i>
        <h2 class="text-3xl font-bold text-gray-900">Modifier l'article : <span class="text-red-600">{{ $article->libelle }}</span></h2>
    </div>

    <form action="{{ route('articles.update', $article->article_id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="codearticle" class="block mb-2 font-medium text-gray-800 flex items-center">
                <i class="fa-solid fa-barcode text-red-500 mr-2"></i>
                Code article <span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-hashtag text-gray-400"></i>
                </div>
                <input type="text" id="codearticle" name="codearticle" value="{{ old('codearticle', $article->codearticle) }}" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/\s]+$"  
                    title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + ou espaces" 
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
            </div>
        </div>

        <div>
            <label for="libelle" class="block mb-2 font-medium text-gray-800 flex items-center">
                <i class="fa-solid fa-tag text-blue-600 mr-2"></i>
                Libellé <span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-box text-gray-400"></i>
                </div>
                <input type="text" id="libelle" name="libelle" value="{{ old('libelle', $article->libelle) }}" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/]+$" 
                    title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + " 
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
            </div>
        </div>

        <div>
            <label for="conditionnement" class="block mb-2 font-medium text-gray-800 flex items-center">
                <i class="fa-solid fa-boxes-stacked text-green-600 mr-2"></i>
                Conditionnement <span class="text-red-500 ml-1">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-cube text-gray-400"></i>
                </div>
                <input type="text" id="conditionnement" name="conditionnement" value="{{ old('conditionnement', $article->conditionnement) }}" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/]+$" 
                    title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > +" 
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="quantitestock" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-cubes text-amber-600 mr-2"></i>
                    Quantité en stock <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="number" id="quantitestock" name="quantitestock" value="{{ old('quantitestock', $article->quantitestock) }}" required min="0" title="La valeur ne peut pas être négative"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    onwheel="event.preventDefault()" />
            </div>

            <div>
                <label for="stockmax" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-arrow-up-wide-short text-blue-600 mr-2"></i>
                    Stock max
                </label>
                <input type="number" id="stockmax" name="stockmax" value="{{ old('stockmax', $article->stockmax) }}" min="0" title="La valeur ne peut pas être négative"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    onwheel="event.preventDefault()" />
            </div>

            <div>
                <label for="stockmin" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-arrow-down-wide-short text-red-600 mr-2"></i>
                    Stock min
                </label>
                <input type="number" id="stockmin" name="stockmin" value="{{ old('stockmin', $article->stockmin) }}" min="0" title="La valeur ne peut pas être négative"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    onwheel="event.preventDefault()" />
            </div>
        </div>

        <div>
            <label for="stocksecurite" class="block mb-2 font-medium text-gray-800 flex items-center">
                <i class="fa-solid fa-shield text-indigo-600 mr-2"></i>
                Stock sécurité <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="number" id="stocksecurite" name="stocksecurite" value="{{ old('stocksecurite', $article->stocksecurite) }}" required min="0" title="La valeur ne peut pas être négative"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                onwheel="event.preventDefault()" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="dateperemption" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-calendar-xmark text-red-600 mr-2"></i>
                    Date de péremption
                </label>
                <input type="date" id="dateperemption" name="dateperemption" value="{{ old('dateperemption', $article->dateperemption) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" title="La date doit être ultérieure à aujourd'hui"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
            </div>

            <div>
                <label for="lot" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-hashtag text-purple-600 mr-2"></i>
                    Lot
                </label>
                <input type="text" id="lot" name="lot" value="{{ old('lot', $article->lot) }}" pattern="^[^,;:\.?!=%@&()$*#^{}<>+/\s]+$" 
                    title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + ou espaces" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
            </div>
        </div>

        <div class="pt-6 border-t border-gray-200">
            <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.01] flex items-center justify-center">
                <i class="fa-solid fa-floppy-disk mr-2 text-lg"></i>
                Mettre à jour l'article
            </button>
        </div>
    </form>
</div>
@endsection