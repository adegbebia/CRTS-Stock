@extends('layouts.app')
@section('content')

    @php
        $peutModifier =
            auth()->user()->hasRole('magasinier_collation') && auth()->user()->magasin_affecte === 'collation';
    @endphp

    <h2 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2" >
        Ajouter un mouvement
    </h2>

    @if (!$peutModifier)
        <p style="color:red;">⚠️ Vous n’êtes pas autorisé à créer un mouvement.</p>
    @endif

    <!-- {{-- Affichage des erreurs --}}
        {{-- @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}} -->

    <!-- <div>
        <p><a href="{{ route('articles.index') }}">← Revenir au niveau des articles</a></p>
    </div> -->

    <form action="{{ $peutModifier ? route('mouvements-articles.store') : '#' }}" method="POST"
        class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md space-y-6"
        {{ !$peutModifier ? 'onsubmit=return false' : '' }}>
        @csrf

        <!-- Organisation en grille -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Article -->
            <div class="md:col-span-3"> 
                @if ($articlesSelectionne)
                    @php
                        $article = $articles->find($articlesSelectionne);
                    @endphp
                    <p class="text-gray-700 font-semibold">
                        Article sélectionné : 
                        <span class="text-red-300">{{ $article->libelle ?? 'N/A' }}</span>
                    </p>
                    <input type="hidden" name="article_id" value="{{ $articlesSelectionne }}">
                @else
                    <label for="article_id" class="block text-sm font-medium text-gray-700">Article</label>
                    <select name="article_id" id="article_id" 
                        class="mt-1 block w-full rounded-md border-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500" 
                        required {{ !$peutModifier ? 'disabled' : '' }}>
                        <option value="">-- Sélectionner un article --</option>
                        @foreach ($articles as $article)
                            <option value="{{ $article->article_id }}" @if (old('article_id') == $article->article_id) selected @endif>
                                {{ $article->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('article_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            <!-- Origine -->
            <div>
                <label for="origine" class="block text-sm font-medium text-gray-700">Origine</label>
                <input type="text" name="origine" id="origine" value="{{ old('origine') }}" pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" required {{ !$peutModifier ? 'disabled' : '' }}
                    class="mt-1 block w-full rounded-md border border-gray-100 md:border-gray-400
                        md:bg-gray-100 p-2 shadow-sm
                        focus:border-red-500 focus:ring-red-500 focus:ring-1">
                @error('origine')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantité commandée -->
            <div>
                <label for="quantite_commandee" class="block text-sm font-medium text-gray-700">Quantité commandée</label>
                <input type="number" name="quantite_commandee" id="quantite_commandee" min="1"
                    value="{{ old('quantite_commandee') }}" {{ !$peutModifier ? 'disabled' : '' }}
                    class="mt-1 block w-full rounded-md border border-gray-100 md:border-gray-400
                        md:bg-gray-100 p-2 shadow-sm
                        focus:border-red-500 focus:ring-red-500 focus:ring-1">
                @error('quantite_commandee')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantité entrée -->
            <div>
                <label for="quantite_entree" class="block text-sm font-medium text-gray-700">Quantité entrée</label>
                <input type="number" name="quantite_entree" id="quantite_entree" min="1"
                    value="{{ old('quantite_entree') }}" {{ !$peutModifier ? 'disabled' : '' }}
                    class="mt-1 block w-full rounded-md border border-gray-300 md:border-gray-400
                        md:bg-gray-100 p-2 shadow-sm
                        focus:border-red-500 focus:ring-red-500 focus:ring-1" />
                @error('quantite_entree')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantité sortie -->
            <div>
                <label for="quantite_sortie" class="block text-sm font-medium text-gray-700">Quantité sortie</label>
                <input type="number" name="quantite_sortie" id="quantite_sortie" min="1"
                    value="{{ old('quantite_sortie') }}" {{ !$peutModifier ? 'disabled' : '' }} 
                    class="mt-1 block w-full rounded-md border border-gray-300 md:border-gray-400
                        md:bg-gray-100 p-2 shadow-sm
                        focus:border-red-500 focus:ring-red-500 focus:ring-1"/>
                @error('quantite_sortie')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Avarie -->
            <div>
                <label for="avarie" class="block text-sm font-medium text-gray-700">Avarie</label>
                <input type="number" name="avarie" id="avarie" min="1" value="{{ old('avarie') }}"
                    {{ !$peutModifier ? 'disabled' : '' }}
                    class="mt-1 block w-full rounded-md border border-gray-400 bg-gray-100 p-2
                        focus:border-red-500 focus:ring-red-500 focus:ring-1" />
                @error('avarie')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observation -->
            <div>
                <label for="observation" class="block text-sm font-medium text-gray-700">Observation</label>
                <textarea name="observation" id="observation"
                    class="mt-1 block w-full rounded-md border border-gray-400 bg-gray-100 p-2 resize-y
                            focus:border-red-500 focus:ring-red-500 focus:ring-1"
                    {{ !$peutModifier ? 'disabled' : '' }}>{{ old('observation') }}</textarea>
                @error('observation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton -->
            @if ($peutModifier)
                <div class="md:col-span-3 flex justify-end">
                    <button type="submit" class="bg-red-300 text-black px-4 py-2 rounded hover:bg-red-500 transition">
                        Créer
                    </button>
                </div>
            @endif

        </div>
    </form>


    <hr class="border-t-2 border-gray-300 my-6"/>

    <h3 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">
        Liste des mouvements déjà créés

    </h3>

   <form method="GET" action="{{ route('mouvements-articles.create') }}"
        class="mb-6 flex flex-wrap items-center gap-4 bg-white p-4 rounded shadow max-w-4xl mx-auto">
    <label for="produit" class="text-gray-700 font-medium">Filtrer par article :</label>
        <select name="article" id="article"
            class="block rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-300" >
            <option value="">-- Tous les articles --</option>
            @foreach($articles as $article)
                <option value="{{ $article->article_id }}" {{ $articlesSelectionne == $article->article_id ? 'selected' : '' }}>
                    {{ $article->libelle }}
                </option>
            @endforeach
        </select>  
        
        

    <!-- <form method="GET" action="{{ route('mouvements-articles.create') }}"
        class="mb-6 flex flex-wrap items-center gap-4 bg-white p-4 rounded shadow max-w-4xl mx-auto"> -->

        <label for="date" class="text-gray-700 font-medium">Filtrer par date :</label>
        <input type="date" name="date" id="date" value="{{ $date }}"
            class="rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-300">

        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Rechercher
        </button>
    </form>


    @if ($mouvements->count())
        <table class="min-w-full border border-gray-300 rounded-lg shadow">
            <thead class="bg-red-200">
                <tr>
                    <th class="px-4 py-2 border">Article</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Origine</th>
                    <th class="px-4 py-2 border">Quantité commandée</th>
                    <th class="px-4 py-2 border">Quantité entrée</th>
                    <th class="px-4 py-2 border">Quantité sortie</th>
                    <th class="px-4 py-2 border">Avarie</th>
                    <th class="px-4 py-2 border">Stock du jour</th>
                    <th class="px-4 py-2 border">Observation</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mouvements as $mouvement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $mouvement->article->libelle ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->date }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->origine }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->quantite_commandee }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->quantite_entree }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->quantite_sortie }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->avarie }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->stock_jour }}</td>
                        <td class="px-4 py-2 border">{{ $mouvement->observation }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('mouvements-articles.edit', $mouvement->mouvementArt_id) }}"
                                class="text-yellow-600 hover:underline" title="Modifier">
                                <button type="button">
                                    <!-- SVG original conservé -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1
                               2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897
                               1.13L6 18l.8-2.685a4.5 4.5 0 0 1
                               1.13-1.897l8.932-8.931Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0 1
                               15.75 21H5.25A2.25 2.25 0 0 1
                               3 18.75V8.25A2.25 2.25 0 0 1
                               5.25 6H10" />
                                    </svg>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="join mt-4 flex justify-end">
            @for ($page = 1; $page <= $mouvements->lastPage(); $page++)
                <input type="radio" name="pagination" aria-label="{{ $page }}"
                    class="join-item btn btn-square bg-red-200 checked:bg-blue-500 checked:text-white"
                    @if ($mouvements->currentPage() == $page) checked @endif
                    onchange="window.location='{{ $mouvements->url($page) }}'" />
            @endfor
        </div>
        <!-- <div class="pagination">
            {{ $mouvements->links() }}
        </div> -->
    @else
        <p>Aucun mouvement enregistré pour le moment.</p>
    @endif

    <!-- SweetAlert2 CDN -->

    {{-- Notification de succès --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: {{ Js::from(session('success')) }},
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    {{-- Notification d’échec --}}
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: {{ Js::from(session('error')) }},
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

@endsection
