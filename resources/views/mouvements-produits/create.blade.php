@extends('layouts.app')
@section('content')

@php
    $peutModifier =
        auth()->user()->hasRole('magasinier_technique') && auth()->user()->magasin_affecte === 'technique';
@endphp

<h2 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-red-600 pb-3 flex items-center">
    <i class="fa-solid fa-arrow-right-arrow-left text-red-600 mr-3 text-2xl"></i>
    Ajouter un mouvement
</h2>

@if (!$peutModifier)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 max-w-3xl mx-auto">
        <div class="flex items-start">
            <i class="fa-solid fa-circle-exclamation text-red-600 text-xl mr-3 mt-0.5"></i>
            <p class="text-red-800 font-medium">⚠️ Vous n'êtes pas autorisé à créer un mouvement.</p>
        </div>
    </div>
@endif

<form action="{{ $peutModifier ? route('mouvements-produits.store') : '#' }}" method="POST"
    class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 p-6 space-y-6"
    {{ !$peutModifier ? 'onsubmit=return false' : '' }}>
    @csrf

    <!-- Organisation desktop -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Produit -->
        <div class="md:col-span-3">
            @if ($produitSelectionne)
                @php
                    $produit = $produits->find($produitSelectionne);
                @endphp
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <p class="text-gray-800 font-semibold flex items-center">
                        <i class="fa-solid fa-box-open text-blue-600 mr-2"></i>
                        Produit sélectionné :
                        <span class="text-red-600 font-bold ml-1">{{ $produit->libelle ?? 'N/A' }}</span>
                    </p>
                    <input type="hidden" name="produit_id" value="{{ $produitSelectionne }}">
                </div>
            @else
                <label for="produit_id" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-box text-red-500 mr-2"></i>
                    Produit <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="produit_id" id="produit_id"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    required {{ !$peutModifier ? 'disabled' : '' }}>
                    <option value="">-- Sélectionner un produit --</option>
                    @foreach ($produits as $produit)
                        <option value="{{ $produit->produit_id }}" @if (old('produit_id') == $produit->produit_id) selected @endif>
                            {{ $produit->libelle }}
                        </option>
                    @endforeach
                </select>

                @error('produit_id')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            @endif
        </div>

        {{-- Origine --}}
        <div>
            <label for="origine" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-truck text-green-600 mr-2"></i>
                Origine <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="text" name="origine" id="origine" value="{{ old('origine') }}" pattern="^[^,;:\.?!=%@&()$*#^{}<>+\/]+$"
                title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /" required {{ !$peutModifier ? 'disabled' : '' }}
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
            @error('origine')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Quantité commandée -->
        <div>
            <label for="quantite_commandee" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-list-check text-blue-600 mr-2"></i>
                Quantité commandée <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="number" name="quantite_commandee" id="quantite_commandee" min="1"
                value="{{ old('quantite_commandee') }}" {{ !$peutModifier ? 'disabled' : '' }}
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                onwheel="event.preventDefault()">
            @error('quantite_commandee')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Quantité entrée -->
        <div>
            <label for="quantite_entree" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-arrow-down text-green-600 mr-2"></i>
                Quantité entrée <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="number" name="quantite_entree" id="quantite_entree" min="1"
                value="{{ old('quantite_entree') }}" {{ !$peutModifier ? 'disabled' : '' }}
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                onwheel="event.preventDefault()"/>
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
            <input type="number" name="quantite_sortie" id="quantite_sortie" min="1"
                value="{{ old('quantite_sortie') }}" {{ !$peutModifier ? 'disabled' : '' }} 
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                onwheel="event.preventDefault()"/>
            @error('quantite_sortie')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
        
        {{-- Avarie --}}
        <div>
            <label for="avarie" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-ban text-yellow-600 mr-2"></i>
                Avarie
            </label>
            <input type="number" name="avarie" id="avarie" min="0" value="{{ old('avarie') }}"
                {{ !$peutModifier ? 'disabled' : '' }}
                class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                onwheel="event.preventDefault()"/>
            @error('avarie')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Nombre rupture stock --}}
        <div>
            <label for="nombre_rupture_stock" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-triangle-exclamation text-orange-600 mr-2"></i>
                Nombre De Rupture Stock
            </label>
            <input type="number" name="nombre_rupture_stock" id="nombre_rupture_stock" min="0" value="{{ old('nombre_rupture_stock') }}"
                {{ !$peutModifier ? 'disabled' : '' }}
                class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                onwheel="event.preventDefault()"/>
            @error('nombre_rupture_stock')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Observation --}}
        <div class="md:col-span-3">
            <label for="observation" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-comment text-purple-600 mr-2"></i>
                Observation
            </label>
            <textarea name="observation" id="observation"
                pattern="^[^,;:\.?!=%@&()$*#^{}<>+\/]+$"
                title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-y min-h-[100px]"
                {{ !$peutModifier ? 'disabled' : '' }}>{{ old('observation') }}</textarea>
            @error('observation')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Bouton -->
        @if ($peutModifier)
            <div class="md:col-span-3 flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] flex items-center">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Enregistrer le mouvement
                </button>
            </div>
        @endif
    </div>
</form>

<hr class="border-t-2 border-gray-200 my-10" />

<h3 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-red-600 pb-3 flex items-center">
    <i class="fa-solid fa-clipboard-list text-red-600 mr-3 text-2xl"></i>
    Liste des mouvements déjà créés
</h3>

<form method="GET" action="{{ route('mouvements-produits.create') }}"
    class="mb-8 flex flex-col sm:flex-row sm:items-center gap-4 bg-white p-5 rounded-xl shadow-sm border border-gray-200 max-w-4xl mx-auto">
    <div class="flex-1 min-w-[200px]">
        <label for="produit" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par produit :</label>
        <select name="produit" id="produit"
                class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500">
            <option disabled selected>-- Tous les produits --</option>
            @foreach ($produits as $produit)
                <option value="{{ $produit->produit_id }}"
                    {{ $produitSelectionne == $produit->produit_id ? 'selected' : '' }}>
                    {{ $produit->libelle }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="flex-1 min-w-[200px]">
        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par date :</label>
        <input type="date" name="date" id="date" value="{{ $date }}"
               class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500" />
    </div>
    <div class="flex-shrink-0">
        <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg shadow transition-all flex items-center">
            <i class="fa-solid fa-magnifying-glass mr-2"></i>
            Rechercher
        </button>
    </div>
</form>

@if ($mouvements->count())
    <div class="overflow-x-auto max-w-7xl mx-auto">
        <table class="min-w-full border border-gray-200 rounded-xl shadow-sm">
            <thead class="bg-gradient-to-r from-red-600 to-red-700">
                <tr>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Produit</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Origine</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Qté commandée</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Qté entrée</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Qté sortie</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Avarie</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Rupture Stock</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Stock du jour</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Observation</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($mouvements as $mouvement)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 border text-sm font-medium text-gray-900">{{ $mouvement->produit->libelle ?? 'N/A' }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $mouvement->date }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $mouvement->origine }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $mouvement->quantite_commandee }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $mouvement->quantite_entree }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $mouvement->quantite_sortie }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $mouvement->avarie }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $mouvement->nombre_rupture_stock }}</td>
                        <td class="px-4 py-3 border text-sm font-semibold text-gray-900">{{ $mouvement->stock_jour }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700 max-w-xs truncate">{{ $mouvement->observation }}</td>
                        <td class="px-4 py-3 border text-sm">
                            <a href="{{ route('mouvements-produits.edit', $mouvement->mouvementProd_id) }}"
                                class="text-amber-600 hover:text-amber-800 transition-colors" title="Modifier">
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
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
    </div>

    {{-- Pagination professionnelle alignée à droite --}}
    <div class="mt-8 flex justify-end max-w-7xl mx-auto">
        <div class="inline-flex rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @for ($page = 1; $page <= $mouvements->lastPage(); $page++)
                <label class="relative">
                    <input type="radio" 
                           name="pagination" 
                           class="absolute inset-0 opacity-0 cursor-pointer"
                           @if ($mouvements->currentPage() == $page) checked @endif 
                           onchange="window.location='{{ $mouvements->url($page) }}'">
                    <span class="px-4 py-2.5 text-sm font-medium transition-all duration-200 cursor-pointer
                                @if($mouvements->currentPage() == $page)
                                    bg-red-600 text-white
                                @else
                                    bg-white text-gray-700 hover:bg-gray-50 hover:text-red-600
                                @endif
                                @if($page < $mouvements->lastPage()) border-r border-gray-200 @endif">
                        {{ $page }}
                    </span>
                </label>
            @endfor
        </div>
    </div>
@else
    <div class="bg-white rounded-xl border-2 border-dashed border-gray-300 p-12 text-center max-w-3xl mx-auto">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-600 mb-4">
            <i class="fa-solid fa-inbox text-3xl"></i>
        </div>
        <p class="text-gray-500 text-lg font-medium">Aucun mouvement enregistré pour le moment.</p>
    </div>
@endif

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: {!! Js::from(session('success')) !!},
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: {!! Js::from(session('error')) !!},
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@endsection