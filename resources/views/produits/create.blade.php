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
            confirmButtonColor: '#dc2626',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then(() => {
            window.location.href = "{{ route('produits.index') }}";
        });
    </script>
@else

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
        <div class="flex items-center mb-8 pb-4 border-b border-gray-200">
            <i class="fa-solid fa-vial text-red-600 text-3xl mr-4"></i>
            <h2 class="text-3xl font-bold text-gray-900">Ajouter un nouveau produit</h2>
        </div>

        <form action="{{ route('produits.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="codeproduit" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-barcode text-red-500 mr-2 text-lg"></i>
                    Code Produit <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" name="codeproduit" id="codeproduit" required pattern="^[^,;:\.?%=!@&()$*#^{}<>+/\s]+$"
                        title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + ou espaces"  value="{{ old('codeproduit') }}" 
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
                </div>
                @error('codeproduit')
                    <p class="text-red-600 mt-1 text-sm flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="libelle" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-tag text-blue-600 mr-2 text-lg"></i>
                    Libellé <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-box text-gray-400"></i>
                    </div>
                    <input type="text" name="libelle" id="libelle" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/]+$"
                        title="Ne doit pas contenir les caractères , ; : @ & () $ * # ^ { } <> + /" value="{{ old('libelle') }}"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
                </div>
                @error('libelle')
                    <p class="text-red-600 mt-1 text-sm flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="conditionnement" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-boxes-stacked text-green-600 mr-2 text-lg"></i>
                    Conditionnement <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-cube text-gray-400"></i>
                    </div>
                    <input type="text" name="conditionnement" id="conditionnement" required pattern="^[^,;:\.?!=%@&()$*#^{}<>+/]+$"
                        title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /" value="{{ old('conditionnement') }}" 
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
                </div>
                @error('conditionnement')
                    <p class="text-red-600 mt-1 text-sm flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="quantitestock" class="block mb-2 font-medium text-gray-800 flex items-center">
                        <i class="fa-solid fa-cubes text-amber-600 mr-2 text-lg"></i>
                        Quantité <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="number" name="quantitestock" id="quantitestock" min="0" required
                        value="{{ old('quantitestock') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                        onwheel="event.preventDefault()" />
                </div>

                <div>
                    <label for="stockmax" class="block mb-2 font-medium text-gray-800 flex items-center">
                        <i class="fa-solid fa-arrow-up-wide-short text-blue-600 mr-2 text-lg"></i>
                        Stock maximum <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="number" name="stockmax" id="stockmax" min="0" required
                        value="{{ old('stockmax') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                        onwheel="event.preventDefault()" />
                </div>

                <div>
                    <label for="stockmin" class="block mb-2 font-medium text-gray-800 flex items-center">
                        <i class="fa-solid fa-arrow-down-wide-short text-red-600 mr-2 text-lg"></i>
                        Stock minimum <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="number" name="stockmin" id="stockmin" min="0" required
                        value="{{ old('stockmin') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                        onwheel="event.preventDefault()" />
                </div>
            </div>

            <div>
                <label for="stocksecurite" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-shield text-indigo-600 mr-2 text-lg"></i>
                    Stock de sécurité <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="number" name="stocksecurite" id="stocksecurite" min="0" required
                    value="{{ old('stocksecurite') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    onwheel="event.preventDefault()" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="dateperemption" class="block mb-2 font-medium text-gray-800 flex items-center">
                        <i class="fa-solid fa-calendar-xmark text-red-600 mr-2 text-lg"></i>
                        Date de péremption <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="date" name="dateperemption" id="dateperemption" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('dateperemption') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
                    @error('dateperemption')
                        <p class="text-red-600 mt-1 text-sm flex items-center">
                            <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="lot" class="block mb-2 font-medium text-gray-800 flex items-center">
                        <i class="fa-solid fa-hashtag text-purple-600 mr-2 text-lg"></i>
                        Lot <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" name="lot" id="lot" pattern="^[^,;:\.?!=%@&()$*#^{}<>+/\s]+$" title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + ou espaces" value="{{ old('lot') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" />
                    @error('lot')
                        <p class="text-red-600 mt-1 text-sm flex items-center">
                            <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="user_id" class="block mb-2 font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-user text-gray-500 mr-2 text-lg"></i>
                    Auteur
                </label>
                <input type="text" id="user_name" value="{{ auth()->user()->nom }}" disabled
                    class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-500 cursor-not-allowed" />
                <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                @error('user_id')
                    <p class="text-red-600 mt-1 text-sm flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="pt-6 border-t border-gray-200">
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.01] flex items-center justify-center">
                    <i class="fa-solid fa-floppy-disk mr-2 text-lg"></i>
                    Enregistrer le produit
                </button>
            </div>
        </form>
    </div>

@endif

@endsection