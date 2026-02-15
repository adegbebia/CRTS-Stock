@extends('layouts.app')
@section('content')

@php
    $user = auth()->user();

    // Permission de voir la page (admin OU magasinier_technique)
    $peutVoir = $user && (
        $user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique'
        || $user->hasRole('admin')
    );

    // Permission de modifier (seulement magasinier_technique affecté au magasin technique)
    $peutModifier = $user && $user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique';
@endphp

<h2 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-red-600 pb-3 flex items-center">
    <i class="fa-solid fa-chart-line text-red-600 mr-3 text-2xl"></i>
    Nouvelle fiche de consommation
</h2>

@if (!$peutVoir)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg max-w-2xl mx-auto mb-8">
        <div class="flex items-start">
            <i class="fa-solid fa-circle-exclamation text-red-600 text-xl mr-3 mt-0.5"></i>
            <p class="text-red-800 font-medium">⚠️ Vous n'êtes pas autorisé à accéder à cette page.</p>
        </div>
    </div>
    @php return; @endphp
@endif

<form action="{{ route('consommations-produits.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <label for="produit_id" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-box text-red-500 mr-2"></i>
                Produit <span class="text-red-500 ml-1">*</span>
            </label>
            <select name="produit_id" id="produit_id" required
                onchange="window.location.href='?produit_id='+this.value+'&annee='+document.getElementById('annee').value;"
                class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                <option value="">-- Choisir un produit --</option>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->produit_id }}"
                        {{ isset($produit_id) && $produit_id == $produit->produit_id ? 'selected' : (old('produit_id') == $produit->produit_id ? 'selected' : '') }}>
                        {{ $produit->libelle }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="annee" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-calendar-year text-blue-600 mr-2"></i>
                Année <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="number" name="annee" id="annee" min="2020" max="{{ date('Y') + 1 }}" required
                value="{{ $annee ?? old('annee', date('Y')) }}"
                onchange="window.location.href='?produit_id='+document.getElementById('produit_id').value+'&annee='+this.value;"
                class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                onwheel="event.preventDefault()">
        </div>
    </div>

    <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-red-500 pb-2 flex items-center">
        <i class="fa-solid fa-calendar-days text-red-600 mr-2"></i>
        SORTIES MENSUELLES
    </h3>

    <div class="overflow-x-auto mb-8">
        <table class="min-w-full border border-gray-200 rounded-xl shadow-sm text-sm">
            <thead class="bg-gradient-to-r from-red-600 to-red-700 text-white">
                <tr>
                    <th class="px-3 py-2 border-b border-red-800 font-bold text-xs uppercase tracking-wider">Mois</th>
                    @php
                        $mois = [
                            'janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin',
                            'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre'
                        ];
                    @endphp
                    @foreach ($mois as $m)
                        <th class="px-2 py-2 border-b border-red-800 font-bold text-xs uppercase tracking-wider">{{ ucfirst($m) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-2 border font-medium text-gray-800">Consommation</td>
                    @foreach ($mois as $index => $m)
                        <td class="px-2 py-2 border text-center font-semibold text-gray-900">
                            {{ $consommations_mensuelles[$index + 1] ?? 0 }}
                            <input type="hidden" name="consommation_{{ $m }}"
                                value="{{ $consommations_mensuelles[$index + 1] ?? 0 }}">
                        </td>
                    @endforeach
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-2 border font-medium text-gray-800">Jours de rupture</td>
                    @foreach ($mois as $index => $m)
                        <td class="px-2 py-2 border text-center font-semibold text-red-600">
                            {{ $ruptures_mensuelles[$index + 1] ?? 0 }}
                            <input type="hidden" name="rupture_{{ $m }}"
                                value="{{ $ruptures_mensuelles[$index + 1] ?? 0 }}">
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    @if ($peutModifier)
        <div class="flex justify-end pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] flex items-center">
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Enregistrer la consommation
            </button>
        </div>
    @endif
</form>

<hr class="border-t-2 border-gray-200 my-10" />

<h3 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-red-600 pb-3 flex items-center">
    <i class="fa-solid fa-list-check text-red-600 mr-3 text-2xl"></i>
    Consommations enregistrées
</h3>

<form method="GET" action="{{ route('consommations-produits.create') }}" 
      class="mb-8 flex flex-col sm:flex-row gap-3 max-w-3xl mx-auto">
    <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
        </div>
        <input name="search" 
               type="search" 
               placeholder="Rechercher un produit..." 
               value="{{ request('search') }}"
               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
    </div>
    <button type="submit" 
            class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg shadow transition-all whitespace-nowrap flex items-center justify-center">
        <i class="fa-solid fa-search mr-2 hidden sm:inline"></i>
        Rechercher
    </button>
</form>

@if ($consommations->count())
    <div class="overflow-x-auto max-w-7xl mx-auto">
        <table class="min-w-full border border-gray-200 rounded-xl shadow-sm">
            <thead class="bg-gradient-to-r from-red-600 to-red-700">
                <tr>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Produit</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Année</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Total annuel</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Trimestre 1</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Trimestre 2</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Trimestre 3</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Trimestre 4</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Semestre 1</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Semestre 2</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($consommations as $c)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 border text-sm font-medium text-gray-900">{{ $c->produit->libelle ?? 'N/A' }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $c->annee }}</td>
                        <td class="px-4 py-3 border text-sm font-semibold text-gray-900">{{ $c->total_annuel }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $c->trimestre1 }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $c->trimestre2 }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $c->trimestre3 }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $c->trimestre4 }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $c->semestre1 }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $c->semestre2 }}</td>
                        <td class="px-4 py-3 border text-sm">
                            @if ($peutModifier)
                                <form id="delete-form-{{ $c->consommationProd_id }}"
                                    action="{{ route('consommations-produits.destroy', ['consommations_produit' => $c->consommationProd_id]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $c->consommationProd_id }}')"
                                        class="text-red-600 hover:text-red-800 transition-colors" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <em class="text-gray-400">Pas d'accès</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination professionnelle alignée à droite --}}
    <div class="mt-8 flex justify-end max-w-7xl mx-auto">
        <div class="inline-flex rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @for ($page = 1; $page <= $consommations->lastPage(); $page++)
                <label class="relative">
                    <input type="radio" 
                           name="pagination" 
                           class="absolute inset-0 opacity-0 cursor-pointer"
                           @if ($consommations->currentPage() == $page) checked @endif 
                           onchange="window.location='{{ $consommations->url($page) }}'">
                    <span class="px-4 py-2.5 text-sm font-medium transition-all duration-200 cursor-pointer
                                @if($consommations->currentPage() == $page)
                                    bg-red-600 text-white
                                @else
                                    bg-white text-gray-700 hover:bg-gray-50 hover:text-red-600
                                @endif
                                @if($page < $consommations->lastPage()) border-r border-gray-200 @endif">
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
        <p class="text-gray-500 text-lg font-medium">Aucune consommation enregistrée pour le moment.</p>
    </div>
@endif

<!-- SweetAlert Suppression -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Supprimer ?",
            text: "Cette action est irréversible !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc2626",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Oui, supprimer",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: {!! json_encode(session('success')) !!},
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
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@endsection