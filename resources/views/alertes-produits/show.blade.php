@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')

@php
    $user = auth()->user();
@endphp

@if($user->hasRole('admin') || ($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique'))
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded shadow-lg">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            🔔 Détails de l'Alerte Produit
        </h2>

        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Informations de l'alerte</h3>
            <ul class="space-y-1 text-gray-700">
                <!-- <li><strong>ID de l'alerte :</strong> {{ $alerte->alerteProd_id }}</li> -->
                <li>
                    <strong>Type d'alerte :</strong>
                    @switch($alerte->typealerte)
                        @case('Alerte rouge')
                            <span class="text-red-600 font-semibold">Stock critique</span>
                            @break
                        @case('Alerte orange')
                            <span class="text-orange-500 font-semibold">Stock faible</span>
                            @break
                        @case('Alerte verte')
                            <span class="text-green-600 font-semibold">Stock acceptable</span>
                            @break
                        @case('Rupture de stock')
                            <span class="text-black font-semibold">Attention stock</span>
                            @break
                        @case('Produit périmé')
                            <span class="text-purple-600 font-semibold">Produit périmé</span>
                            @break
                        @default
                            <span class="text-gray-500">Inconnu</span>
                    @endswitch
                </li>
                <li>
                    <strong>Déclenchée le :</strong>
                    {{ $alerte->datedeclenchement 
                        ? Carbon::parse($alerte->datedeclenchement)->format('d/m/Y H:i') 
                        : 'N/A' 
                    }}
                </li>
            </ul>
        </div>

        @if($alerte->produit)
            <div class="mt-6 border-t pt-4">
                <h3 class="text-lg font-semibold mb-3 text-gray-700">Informations du produit lié</h3>
                <ul class="list-disc list-inside space-y-1 text-gray-700">
                    <li><strong>Libellé :</strong> {{ $alerte->produit->libelle ?? 'N/A' }}</li>
                    <li><strong>Lot :</strong> {{ $alerte->produit->lot ?? 'N/A' }}</li>
                    <li><strong>Quantité en stock :</strong> {{ $alerte->produit->quantitestock ?? 'N/A' }}</li>
                    <li>
                        <strong>Date de péremption :</strong> 
                        {{ $alerte->produit->dateperemption 
                            ? Carbon::parse($alerte->produit->dateperemption)->format('d/m/Y') 
                            : 'N/A' 
                        }}
                    </li>
                    <li><strong>Stock sécurité :</strong> {{ $alerte->produit->stocksecurite ?? 'N/A' }}</li>
                    <li><strong>Stock min :</strong> {{ $alerte->produit->stockmin ?? 'N/A' }}</li>
                    <li><strong>Stock max :</strong> {{ $alerte->produit->stockmax ?? 'N/A' }}</li>
                </ul>
            </div>
        @else
            <div class="mt-6 text-red-500 font-semibold">
                ⚠️ Aucune information de produit disponible pour cette alerte.
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('alertes-produits.index') }}" 
            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                ← Retour à la liste
            </a>
        </div>

    </div>
@else
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Accès refusé',
            text: 'Vous n\'êtes pas autorisé à consulter cette alerte.',
        });
    </script>
@endif

@endsection
