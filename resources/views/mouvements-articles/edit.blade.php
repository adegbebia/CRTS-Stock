@extends('layouts.app')
@section('content')

@php
    $user = auth()->user();
    $peutModifier = $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation';
@endphp

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
    <div class="flex items-center mb-8 pb-4 border-b border-gray-200">
        <i class="fa-solid fa-pen-to-square text-red-600 text-3xl mr-4"></i>
        <h2 class="text-3xl font-bold text-gray-900">Modifier le mouvement</h2>
    </div>

    @if (!$peutModifier)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-8">
            <div class="flex items-start">
                <i class="fa-solid fa-circle-exclamation text-red-600 text-xl mr-3 mt-0.5"></i>
                <p class="text-red-800 font-medium">⚠️ Vous n'êtes pas autorisé à modifier ce mouvement.</p>
            </div>
        </div>
    @endif

    <form action="{{ $peutModifier ? route('mouvements-articles.update', ['mouvements_article' => $mouvement->mouvementArt_id]) : '#' }}" 
        method="POST" {{ !$peutModifier ? 'onsubmit=return false' : '' }}
        class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Article -->
        <div>
            <label for="article_id" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-bowl-food text-red-500 mr-2"></i>
                Article <span class="text-red-500 ml-1">*</span>
            </label>
            <select name="article_id" id="article_id" required {{ !$peutModifier ? 'disabled' : '' }}
                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                           focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all">
                @foreach ($articles as $article)
                    <option value="{{ $article->article_id }}" {{ $mouvement->article_id == $article->article_id ? 'selected' : '' }}>
                        {{ $article->libelle }}
                    </option>
                @endforeach
            </select>
            @error('article_id')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="origine" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-truck text-green-600 mr-2"></i>
                Origine <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="text" name="origine" id="origine" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+\/]+$" 
                title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + '' /" value="{{ old('origine', $mouvement->origine) }}" 
                {{ !$peutModifier ? 'disabled' : '' }}
                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                          focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all">
            @error('origine')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="quantite_commandee" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-list-check text-blue-600 mr-2"></i>
                    Quantité commandée <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" value="{{ old('quantite_commandee', $mouvement->quantite_commandee) }}"  
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                              focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all"
                              onwheel="event.preventDefault()">
                @error('quantite_commandee')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="quantite_entree" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-arrow-down text-green-600 mr-2"></i>
                    Quantité entrée <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="number" name="quantite_entree" id="quantite_entree" min="1" value="{{ old('quantite_entree', $mouvement->quantite_entree) }}" 
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                              focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all"
                              onwheel="event.preventDefault()">
                @error('quantite_entree')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="quantite_sortie" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-arrow-up text-red-600 mr-2"></i>
                    Quantité sortie <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="number" name="quantite_sortie" id="quantite_sortie" min="1" value="{{ old('quantite_sortie', $mouvement->quantite_sortie) }}" 
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                              focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all"
                              onwheel="event.preventDefault()">
                @error('quantite_sortie')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="avarie" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-ban text-yellow-600 mr-2"></i>
                    Avarie
                </label>
                <input type="number" name="avarie" id="avarie" min="0" value="{{ old('avarie', $mouvement->avarie) }}" 
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 shadow-sm
                              focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all"
                              onwheel="event.preventDefault()">
                @error('avarie')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="nombre_rupture_stock" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-triangle-exclamation text-orange-600 mr-2"></i>
                    Nombre De Rupture Stock
                </label>
                <input type="number" name="nombre_rupture_stock" id="nombre_rupture_stock" min="0"
                       value="{{ old('nombre_rupture_stock', $mouvement->nombre_rupture_stock) }}"
                       {{ !$peutModifier ? 'disabled' : '' }}
                       class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 shadow-sm
                              focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all"
                              onwheel="event.preventDefault()">
                @error('nombre_rupture_stock')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Observation -->
        <div>
            <label for="observation" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-comment text-purple-600 mr-2"></i>
                Observation
            </label>
            <textarea name="observation" id="observation"
                    pattern="^[^,;:\.?!=%@&()$*#^{}<>+\/]+$"
                    title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                            focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 resize-y min-h-[100px] transition-all">{{ old('observation', $mouvement->observation) }}</textarea>
            @error('observation')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        @if ($peutModifier)
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] flex items-center">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Enregistrer les modifications
                </button>
            </div>
        @endif        
    </form>

    <div class="mt-8 pt-6 border-t border-gray-200">
        <a href="{{ route('mouvements-articles.create', ['article_id' => $mouvement->mouvementArt_id]) }}"
            class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium hover:underline transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Revenir à l'article concerné
        </a>
    </div>
</div>

@endsection