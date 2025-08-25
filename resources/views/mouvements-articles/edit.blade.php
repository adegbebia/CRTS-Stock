@extends('layouts.app')
@section('content')

    @php
        $user = auth()->user();
        $peutModifier = $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation';
    @endphp
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Modifier le mouvement</h2>

        @if (!$peutModifier)
            <p class="text-red-600 mb-6 font-medium">⚠️ Vous n’êtes pas autorisé à modifier ce mouvement.</p>
        @endif

        <form action="{{ $peutModifier ? route('mouvements-articles.update', ['mouvements_article' => $mouvement->mouvementArt_id]) : '#' }}" 
            method="POST" {{ !$peutModifier ? 'onsubmit=return false' : '' }}
            class="space-y-5" >
            @csrf
            @method('PUT')
            <!-- Article -->
            <div>
                <label for="article_id" class="block text-sm font-medium text-gray-700 mb-1">Article</label>
                <select name="article_id" id="article_id" required {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                               focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900">
                    @foreach ($articles as $article)
                        <option value="{{ $article->article_id }}" {{ $mouvement->article_id == $article->article_id ? 'selected' : '' }}>
                            {{ $article->libelle }}
                        </option>
                    @endforeach
                </select>
                @error('article_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="origine" class="block text-sm font-medium text-gray-700 mb-1">Origine</label>
                <input type="text" name="origine" id="origine" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+\/]+$" 
                    title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + '' /" value="{{ old('origine', $mouvement->origine) }}" 
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                              focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900">
                @error('origine')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantite_commandee" class="block text-sm font-medium text-gray-700 mb-1">Quantité commandée</label>
                <input type="number" name="quantite_commandee" id="quantite_commandee" min="1" value="{{ old('quantite_commandee', $mouvement->quantite_commandee) }}"  
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                              focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900"
                              onwheel="event.preventDefault()">
                @error('quantite_commandee')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantite_entree" class="block text-sm font-medium text-gray-700 mb-1">Quantité entrée</label>
                <input type="number" name="quantite_entree" id="quantite_entree" min="1" value="{{ old('quantite_entree', $mouvement->quantite_entree) }}" 
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                              focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900"
                              onwheel="event.preventDefault()">
                @error('quantite_entree')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantite_sortie" class="block text-sm font-medium text-gray-700 mb-1">Quantité sortie</label>
                <input type="number" name="quantite_sortie" id="quantite_sortie" min="1" value="{{ old('quantite_sortie', $mouvement->quantite_sortie) }}" 
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                              focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900"
                              onwheel="event.preventDefault()" >
                @error('quantite_sortie')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- <div>
                <label for="stock_debut_mois">Stock début du mois</label>
                <input type="number" name="stock_debut_mois" id="stock_debut_mois" min="1" value="{{ old('stock_debut_mois', $mouvement->stock_debut_mois) }}" required {{ !$peutModifier ? 'disabled' : '' }} >
                @error('stock_debut_mois')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div> -->

            <div>
                <label for="avarie" class="block text-sm font-medium text-gray-700 mb-1" >Avarie</label>
                <input type="number" name="avarie" id="avarie" min="0" value="{{ old('avarie', $mouvement->avarie) }}" 
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                              focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900"
                              onwheel="event.preventDefault()">
                @error('avarie')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombre_rupture_stock" class="block text-sm font-medium text-gray-700 mb-1">Nombre De Rupture Stock</label>
                <input type="number" name="nombre_rupture_stock" id="nombre_rupture_stock" min="0"
                       value="{{ old('nombre_rupture_stock', $mouvement->nombre_rupture_stock) }}"
                       {{ !$peutModifier ? 'disabled' : '' }}
                       class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                              focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900"
                              onwheel="event.preventDefault()">
                @error('nombre_rupture_stock')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Observation -->
            <div>
                <label for="observation" class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                <textarea name="observation" id="observation"
                        pattern="^[^,;:\.?!=%@&()$*#^{}<>+\/]+$"
                        title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                        {{ !$peutModifier ? 'disabled' : '' }}
                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                                focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900 resize-y min-h-[80px]">{{ old('observation', $mouvement->observation) }}</textarea>
                @error('observation')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            
            @if ($peutModifier)
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-red-400 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400">
                        Enregistrer
                    </button>
                </div>
            @endif        
        </form>
        <div>
            <a href="{{ route('mouvements-articles.create', ['article_id' => $mouvement->mouvementArt_id]) }}"
                class="text-blue-600 hover:underline">
                ← Revenir a l'article concerné</a>
        </div>

        
    </div>

@endsection
