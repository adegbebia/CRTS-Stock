@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-red-600 pb-3 flex items-center">
    <i class="fa-solid fa-utensils text-red-600 mr-3 text-2xl"></i>
    Liste des articles stockés
</h2>

@php
    $user = auth()->user();
@endphp

@if($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')
    <div class="flex justify-end mb-6">
        <a href="{{ route('articles.create') }}" 
           class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 inline-flex items-center p-2.5 rounded-lg text-white shadow-md hover:shadow-lg transition-all"
           title="Ajouter un article">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20" class="text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </a>
    </div>
@endif

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: @json(session('success')),
        confirmButtonColor: '#dc2626'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Accès refusé',
        text: @json(session('error')),
        confirmButtonColor: '#dc2626'
    });
</script>
@endif

@if ($articles->isEmpty())
    <div class="bg-white rounded-xl border-2 border-dashed border-gray-300 p-12 text-center max-w-3xl mx-auto">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-600 mb-4">
            <i class="fa-solid fa-box-open text-3xl"></i>
        </div>
        <p class="text-gray-500 text-lg font-medium">Aucun article enregistré pour le moment.</p>
    </div>
@else
    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('articles.index') }}" class="mb-6 flex flex-col sm:flex-row gap-3">
        <label class="input inline-flex items-center border border-gray-300 rounded-lg px-3 py-2 bg-white focus-within:ring-2 focus-within:ring-red-500 focus-within:border-red-500 transition-all flex-1 max-w-md">
            <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
            <input name="search" type="search" placeholder="Rechercher un article..." value="{{ request('search') }}"
                class="outline-none w-full text-gray-700 placeholder-gray-400">
        </label>
        <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-medium shadow transition hover:shadow-md whitespace-nowrap"
            type="submit">
            <i class="fa-solid fa-magnifying-glass mr-1.5 hidden sm:inline"></i>
            Rechercher
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-xl shadow-sm">
            <thead class="bg-gradient-to-r from-red-600 to-red-700">
                <tr>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Code</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Libellé</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Conditionnement</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">QtéStock</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Stock max</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Stock min</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Stock sécurité</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Date péremption</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Lot</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Date création</th>
                    <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($articles as $article)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->codearticle }}</td>
                    <td class="px-4 py-3 border text-sm font-medium text-gray-900">{{ $article->libelle }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->conditionnement }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->quantitestock }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->stockmax }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->stockmin }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->stocksecurite }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->dateperemption }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ $article->lot }}</td>
                    <td class="px-4 py-3 border text-sm text-gray-700">{{ \Carbon\Carbon::parse($article->date)->translatedFormat('d F Y') }}</td>
                    <td class="px-4 py-3 border text-sm font-medium space-x-2">
                        <!-- Voir -->
                        <a href="{{ route('articles.show', $article->article_id) }}" 
                            class="text-blue-600 hover:text-blue-800 transition-colors" title="Voir">
                            <button type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007
                        9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5
                        12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </a>

                        @php $user = auth()->user(); @endphp
                        @if($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation' && $article->user_id === $user->user_id)
                            <!-- Modifier -->
                            <a href="{{ route('articles.edit', $article->article_id) }}" 
                                class="text-amber-600 hover:text-amber-800 transition-colors" title="Modifier">
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1
                                            2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897
                                            1.13L6 18l.8-2.685a4.5 4.5 0 0 1
                                            1.13-1.897l8.932-8.931Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 14v4.75A2.25 2.25 0 0 1
                                            15.75 21H5.25A2.25 2.25 0 0 1
                                            3 18.75V8.25A2.25 2.25 0 0 1
                                            5.25 6H10" />
                                    </svg>
                                </button>
                            </a>

                            <!-- Supprimer -->
                            <form id="delete-form-{{ $article->article_id }}"
                                action="{{ route('articles.destroy', $article->article_id) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="confirmDelete('{{ $article->article_id }}')" 
                                        class="text-red-600 hover:text-red-800 transition-colors" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107
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

                            <!-- Mouvement -->
                            <a href="{{ route('mouvements-articles.create', ['article' => $article->article_id]) }}">
                                <button type="button" class="text-green-600 hover:text-green-800 transition-colors" title="Enregistrer un mouvement">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
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
    </div>

    {{-- Pagination professionnelle alignée à droite --}}
    <div class="mt-8 flex justify-end">
        <div class="inline-flex rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @for ($page = 1; $page <= $articles->lastPage(); $page++)
                <label class="relative">
                    <input type="radio" 
                           name="pagination" 
                           class="absolute inset-0 opacity-0 cursor-pointer"
                           @if ($articles->currentPage() == $page) checked @endif 
                           onchange="window.location='{{ $articles->url($page) }}'">
                    <span class="px-4 py-2.5 text-sm font-medium transition-all duration-200 cursor-pointer
                                @if($articles->currentPage() == $page)
                                    bg-red-600 text-white
                                @else
                                    bg-white text-gray-700 hover:bg-gray-50 hover:text-red-600
                                @endif
                                @if($page < $articles->lastPage()) border-r border-gray-200 @endif">
                        {{ $page }}
                    </span>
                </label>
            @endfor
        </div>
    </div>
@endif

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@endsection