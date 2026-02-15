@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')

@php
    $user = auth()->user();
@endphp

@if($user->hasRole('admin') || ($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique'))
    <div class="max-w-4xl mx-auto mt-8 bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
        <div class="flex items-center mb-8 pb-4 border-b border-red-600">
            <i class="fa-solid fa-circle-exclamation text-red-600 text-3xl mr-4"></i>
            <h2 class="text-3xl font-bold text-gray-900">Détails de l'Alerte Produit</h2>
        </div>

        <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fa-solid fa-bell text-red-600 mr-2"></i>
                Informations de l'alerte
            </h3>
            <ul class="space-y-3">
                <li class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-tag text-blue-600 mr-2 text-lg"></i>
                        Type d'alerte
                    </span>
                    <span class="mt-2 sm:mt-0">
                        @switch($alerte->typealerte)
                            @case('Alerte rouge')
                                <span class="px-4 py-1.5 bg-red-100 text-red-800 rounded-full font-bold text-sm flex items-center">
                                    <i class="fa-solid fa-triangle-exclamation mr-2 text-red-600"></i>
                                    Stock critique
                                </span>
                                @break
                            @case('Alerte orange')
                                <span class="px-4 py-1.5 bg-orange-100 text-orange-800 rounded-full font-bold text-sm flex items-center">
                                    <i class="fa-solid fa-circle-exclamation mr-2 text-orange-600"></i>
                                    Stock faible
                                </span>
                                @break
                            @case('Alerte verte')
                                <span class="px-4 py-1.5 bg-green-100 text-green-800 rounded-full font-bold text-sm flex items-center">
                                    <i class="fa-solid fa-check-circle mr-2 text-green-600"></i>
                                    Stock acceptable
                                </span>
                                @break
                            @case('Rupture de stock')
                                <span class="px-4 py-1.5 bg-yellow-100 text-yellow-800 rounded-full font-bold text-sm flex items-center">
                                    <i class="fa-solid fa-bolt mr-2 text-yellow-600"></i>
                                    Attention stock
                                </span>
                                @break
                            @case('Produit périmé')
                                <span class="px-4 py-1.5 bg-purple-100 text-purple-800 rounded-full font-bold text-sm flex items-center">
                                    <i class="fa-solid fa-calendar-xmark mr-2 text-purple-600"></i>
                                    Produit périmé
                                </span>
                                @break
                            @default
                                <span class="px-4 py-1.5 bg-gray-100 text-gray-800 rounded-full font-bold text-sm">
                                    Inconnu
                                </span>
                        @endswitch
                    </span>
                </li>
                <li class="flex flex-col sm:flex-row sm:justify-between sm:items-start pt-3 border-t border-gray-200">
                    <span class="font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-clock text-gray-500 mr-2 text-lg"></i>
                        Déclenchée le
                    </span>
                    <span class="mt-2 sm:mt-0 text-gray-900 font-semibold">
                        {{ $alerte->datedeclenchement 
                            ? Carbon::parse($alerte->datedeclenchement)->translatedFormat('d F Y à H:i') 
                            : 'N/A' 
                        }}
                    </span>
                </li>
            </ul>
        </div>

        @if($alerte->produit)
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fa-solid fa-box-open text-red-600 mr-2"></i>
                    Informations du produit lié
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-tag text-blue-600 mr-2"></i>
                            Libellé
                        </p>
                        <p class="font-medium text-gray-900">{{ $alerte->produit->libelle ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-cube text-green-600 mr-2"></i>
                            Conditionnement
                        </p>
                        <p class="font-medium text-gray-900">{{ $alerte->produit->conditionnement ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-cubes text-amber-600 mr-2"></i>
                            Quantité en stock
                        </p>
                        <p class="font-medium text-gray-900">{{ $alerte->produit->quantitestock ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-calendar-xmark text-red-600 mr-2"></i>
                            Date de péremption
                        </p>
                        <p class="font-medium text-gray-900">
                            {{ $alerte->produit->dateperemption 
                                ? Carbon::parse($alerte->produit->dateperemption)->format('d/m/Y') 
                                : 'N/A' 
                            }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-shield text-indigo-600 mr-2"></i>
                            Stock sécurité
                        </p>
                        <p class="font-medium text-gray-900">{{ $alerte->produit->stocksecurite ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-arrow-down-wide-short text-red-600 mr-2"></i>
                            Stock min
                        </p>
                        <p class="font-medium text-gray-900">{{ $alerte->produit->stockmin ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-arrow-up-wide-short text-blue-600 mr-2"></i>
                            Stock max
                        </p>
                        <p class="font-medium text-gray-900">{{ $alerte->produit->stockmax ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <i class="fa-solid fa-hashtag text-purple-600 mr-2"></i>
                            Lot
                        </p>
                        <p class="font-medium text-gray-900">{{ $alerte->produit->lot ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-xl mr-3 mt-0.5"></i>
                    <p class="text-red-800 font-medium">⚠️ Aucune information de produit disponible pour cette alerte.</p>
                </div>
            </div>
        @endif

        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
            <a href="{{ route('alertes-produits.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Retour à la liste des alertes
            </a>
        </div>
    </div>
@else
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Accès refusé',
            text: 'Vous n\'êtes pas autorisé à consulter cette alerte.',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@endsection