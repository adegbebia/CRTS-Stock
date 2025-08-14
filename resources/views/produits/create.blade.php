@extends('layouts.app')

@section('title', 'produits')

@section('content')

@php
    $user = auth()->user();
    $canCreate = $user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique';
@endphp

@if (!$canCreate)
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Accès refusé',
            text: 'Vous n\'avez pas la permission de créer un produit.',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(() => {
            window.location.href = "{{ route('produits.index') }}";
        });
    </script>
@else

    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Ajouter / Créer un nouveau produit</h2>

        <form action="{{ route('produits.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="codeproduit" class="block mb-1 font-medium text-gray-700">Code Produit</label>
                <input type="text" name="codeproduit" id="codeproduit" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('codeproduit') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                @error('codeproduit')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="libelle" class="block mb-1 font-medium text-gray-700">Libellé</label>
                <input type="text" name="libelle" id="libelle" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('libelle') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                @error('libelle')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="conditionnement" class="block mb-1 font-medium text-gray-700">Conditionnement</label>
                <input type="text" name="conditionnement" id="conditionnement" required pattern="[^,;:]+"
                    title="Ne doit pas contenir les caractères , ; :" value="{{ old('conditionnement') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                @error('conditionnement')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantitestock" class="block mb-1 font-medium text-gray-700">Quantité</label>
                <input type="number" name="quantitestock" id="quantitestock" min="0" required
                    value="{{ old('quantitestock') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                    onwheel="event.preventDefault()" />
            </div>

            <div>
                <label for="stockmax" class="block mb-1 font-medium text-gray-700">Stock maximum</label>
                <input type="number" name="stockmax" id="stockmax" min="0" required
                    value="{{ old('stockmax') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                    onwheel="event.preventDefault()" />
            </div>

            <div>
                <label for="stockmin" class="block mb-1 font-medium text-gray-700">Stock minimum</label>
                <input type="number" name="stockmin" id="stockmin" min="0" required
                    value="{{ old('stockmin') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                    onwheel="event.preventDefault()" />
            </div>

            <div>
                <label for="stocksecurite" class="block mb-1 font-medium text-gray-700">Stock de sécurité</label>
                <input type="number" name="stocksecurite" id="stocksecurite" min="0" required
                    value="{{ old('stocksecurite') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                    onwheel="event.preventDefault()" />
            </div>
            <div>
                <label for="dateperemption" class="block mb-1 font-medium text-gray-700">Date de péremption</label>
                <input type="date" name="dateperemption" id="dateperemption"  min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('dateperemption') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                @error('dateperemption')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lot" class="block mb-1 font-medium text-gray-700">Lot</label>
                <input type="text" name="lot" id="lot"  pattern="[^,;:]+" title="Ne doit pas contenir les caractères , ; :" value="{{ old('lot') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                @error('lot')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="user_id" class="block mb-1 font-medium text-gray-700">Auteur</label>
                <input type="text" id="user_name" value="{{ auth()->user()->nom }}" disabled
                    class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 cursor-not-allowed" />
                <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                @error('user_id')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-red-300 hover:bg-red-600 text-white font-semibold py-3 rounded transition duration-200">
                    Enregistrer
                </button>
            </div>
        </form>

        {{-- <div class="mt-6 flex justify-between text-sm text-gray-600">
            <a href="{{ route('produits.index') }}" class="hover:underline">← Retour à la liste des produits</a>
            <a href="{{ route('mouvements-produits.create') }}" class="hover:underline">→ Enregistrer un mouvement</a>
        </div> --}}
    </div>

@endif

@endsection
