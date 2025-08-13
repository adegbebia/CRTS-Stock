@extends('layouts.app')


@section('content')

    @php
        $user = auth()->user();
        $canCreate = $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation';
    @endphp

    @if (!$canCreate)
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Accès refusé',
                text: 'Vous n\'avez pas la permission de créer un article.',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then(() => {
                window.location.href = "{{ route('articles.index') }}";
            });
        </script>
    @else
        <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Ajouter / Créer un nouvel article</h2>     
            <form action="{{ route('articles.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="codearticle" class="block mb-1 font-medium text-gray-700">Code Article</label>
                    <input type="text" name="codearticle" id="codearticle" required pattern="[^,;:]+"
                        title="Ne doit pas contenir les caractères , ; :" value="{{ old('codearticle') }}" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                    @error('codearticle')
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
                    <input type="date" name="dateperemption" id="dateperemption" required
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('dateperemption') }}" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                    @error('dateperemption')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lot" class="block mb-1 font-medium text-gray-700">Lot</label>
                    <input type="text" name="lot" id="lot" required pattern="[^,;:]+"
                        title="Ne doit pas contenir les caractères , ; :" value="{{ old('lot') }}" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400" />
                    @error('lot')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="user_id" class="block mb-1 font-medium text-gray-700">Auteur</label><br>
                    <input type="text" id="user_name" value="{{ auth()->user()->nom }}" disabled
                        class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 cursor-not-allowed" />
                    <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                    @error('user_id')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>


                <br>
                <div class="pt-6">
                    <button type="submit" class="w-full bg-red-300 hover:bg-red-600 text-white font-semibold py-3 rounded transition duration-200">
                        Enregistrer  
                    </button>
                </div>
            </form>

            <br>
            <br>
            {{--<div>
                <a href="{{ route('articles.index') }}">← Retour à la liste des articles</a>
                <a href="{{ route('mouvements-articles.create') }}">→ Enregistrer un mouvement</a>
            </div> --}}
        </div>
    @endif
@endsection
