@extends('layouts.app')

@section('title', '')

@section('content')

    <h2 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">
        Liste des produits stockés
    </h2>


    @php
        $user = auth()->user();
    @endphp
    @if ($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')
        <div class="flex justify-end">
            <a href="{{ route('produits.create') }}" class="bg-red-200 inline-flex items-center p-1 rounded hover:bg-gray-100"
                title="Ajouter un produit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" width="20" height="20" class="text-red-300">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: @json(session('success')),
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Accès refusé',
                text: @json(session('error')),
            });
        </script>
    @endif

    @if ($produits->isEmpty())
        <p>Aucun produit enregistré pour le moment.</p>
    @else
        {{-- Formulaire de recherche --}}
        <form method="GET" action="{{ route('produits.index') }}" style="margin-bottom: 20px;">
            <label class="input inline-flex items-center border rounded px-2 py-1 mr-2">
                <svg class="h-5 w-5 opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input name="search" type="search" required placeholder="Search" value="{{ request('search') }}"
                    class="outline-none" />
            </label>
            <button class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-red-600 transition"
                type="submit">Rechercher</button>
        </form>

        <table class="min-w-full border border-gray-300 rounded-lg shadow">
            <thead class="bg-red-200">
                <tr>
                    <th class="px-4 py-2 border">Code</th>
                    <th class="px-4 py-2 border">Libellé</th>
                    <th class="px-4 py-2 border">Conditionnement</th>
                    <th class="px-4 py-2 border">QtéStock</th>
                    <th class="px-4 py-2 border">Stock max</th>
                    <th class="px-4 py-2 border">Stock min</th>
                    <th class="px-4 py-2 border">Stock sécurité</th>
                    <th class="px-4 py-2 border">Date péremption</th>
                    <th class="px-4 py-2 border">Lot</th>
                    <th class="px-4 py-2 border">Date de création</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produits as $produit)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $produit->codeproduit }}</td>
                        <td class="px-4 py-2 border">{{ $produit->libelle }}</td>
                        <td class="px-4 py-2 border">{{ $produit->conditionnement }}</td>
                        <td class="px-4 py-2 border">{{ $produit->quantitestock }}</td>
                        <td class="px-4 py-2 border">{{ $produit->stockmax }}</td>
                        <td class="px-4 py-2 border">{{ $produit->stockmin }}</td>
                        <td class="px-4 py-2 border">{{ $produit->stocksecurite }}</td>
                        <td class="px-4 py-2 border">{{ $produit->dateperemption }}</td>
                        <td class="px-4 py-2 border">{{ $produit->lot }}</td>
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($produit->date)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-4 py-2 border">
                            <!-- Voir -->
                            <a href="{{ route('produits.show', $produit->produit_id) }}"
                                class="text-indigo-600 hover:underline" title="Voir">
                                <button type="button">
                                    {{-- ton SVG voir --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007
                                                                           9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5
                                                                           12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </a>

                            @php $user = auth()->user(); @endphp
                            @if (
                                $user->hasRole('magasinier_technique') &&
                                    $user->magasin_affecte === 'technique' &&
                                    $produit->user_id === $user->user_id)
                                <a href="{{ route('produits.edit', $produit->produit_id) }}"
                                    class="text-yellow-600 hover:underline" title="Modifier">
                                    <button type="button">
                                        {{-- ton SVG modifier --}}
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

                                <form id="delete-form-{{ $produit->produit_id }}"
                                    action="{{ route('produits.destroy', $produit->produit_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $produit->produit_id }}')"
                                        class="text-red-300 hover:underline" title="Supprimer">
                                        {{-- ton SVG supprimer --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107
                                                                            1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0
                                                                            1-2.244 2.077H8.084a2.25 2.25 0 0
                                                                            1-2.244-2.077L4.772 5.79m14.456 0a48.108
                                                                            48.108 0 0 0-3.478-.397m-12
                                                                            .562c.34-.059.68-.114 1.022-.165m0
                                                                            0a48.11 48.11 0 0 1 3.478-.397m7.5
                                                                            0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964
                                                                            51.964 0 0 0-3.32 0c-1.18.037-2.09
                                                                            1.022-2.09 2.201v.916m7.5 0a48.667
                                                                            48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>

                                <br>
                                <a href="{{ route('mouvements-produits.create', ['produit' => $produit->produit_id]) }}">
                                    <button type="button" class="text-green-600" title="Enregistrer un mouvement">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        </table>




    @endif
    <div class="join mt-4 flex justify-end">
        @for ($page = 1; $page <= $produits->lastPage(); $page++)
            <input type="radio" name="pagination" aria-label="{{ $page }}"
                class="join-item btn btn-square bg-red-200 checked:bg-blue-500 checked:text-white"
                @if ($produits->currentPage() == $page) checked @endif
                onchange="window.location='{{ $produits->url($page) }}'" />
        @endfor
    </div>





    {{-- <div class="join grid grid-cols-2">
        <button class="join-item btn btn-outline">Previous page</button>
        <button class="join-item btn btn-outline">Next</button>
    </div> --}}


    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Supprimer ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>


@endsection
