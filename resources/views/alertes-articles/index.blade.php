@extends('layouts.app')

@section('title', 'Liste des alertes articles')

@section('content')

@php
    $user = auth()->user();
@endphp

@if($user->hasRole('admin') || ($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation'))

    <h1 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-red-600 pb-3 flex items-center">
        <i class="fa-solid fa-bell text-red-600 mr-3 text-2xl"></i>
        Liste des alertes articles
    </h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-800 border-l-4 border-green-500 rounded-r-lg flex items-start animate-fade-in">
            <i class="fa-solid fa-circle-check text-green-600 text-xl mr-3 mt-0.5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($alerteArticles->isEmpty())
        <div class="bg-white rounded-xl border-2 border-dashed border-gray-300 p-12 text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                <i class="fa-solid fa-check-circle text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune alerte à signaler</h3>
            <p class="text-gray-500 max-w-md mx-auto">Tous les stocks sont dans des limites acceptables. Félicitations pour votre gestion proactive.</p>
        </div>
    @else
        <div class="overflow-x-auto max-w-7xl mx-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-xl shadow-sm">
                <thead class="bg-gradient-to-r from-red-600 to-red-700">
                    <tr>
                        <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Article</th>
                        <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Type d'alerte</th>
                        <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Date déclenchement</th>
                        <th class="px-4 py-3 border-b border-red-800 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($alerteArticles as $alerte)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 border text-sm font-medium text-gray-900">{{ $alerte->article->libelle ?? 'Article inconnu' }}</td>
                            <td class="px-4 py-3 border">
                                @switch($alerte->typealerte)
                                    @case('Alerte rouge')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold flex items-center">
                                            <i class="fa-solid fa-triangle-exclamation mr-1.5 text-red-600"></i>
                                            Stock critique
                                        </span>
                                        @break
                                    @case('Alerte orange')
                                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-bold flex items-center">
                                            <i class="fa-solid fa-circle-exclamation mr-1.5 text-orange-600"></i>
                                            Stock faible
                                        </span>
                                        @break
                                    @case('Rupture de stock')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold flex items-center">
                                            <i class="fa-solid fa-bolt mr-1.5 text-yellow-600"></i>
                                            Rupture imminente
                                        </span>
                                        @break
                                    @case('Alerte verte')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold flex items-center">
                                            <i class="fa-solid fa-check-circle mr-1.5 text-green-600"></i>
                                            Stock acceptable
                                        </span>
                                        @break
                                    @default
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-bold flex items-center">
                                            <i class="fa-solid fa-calendar-xmark mr-1.5 text-gray-600"></i>
                                            Article périmé
                                        </span>
                                @endswitch
                            </td>
                            <td class="px-4 py-3 border text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($alerte->datedeclenchement)->translatedFormat('d F Y à H:i') }}
                            </td>
                            <td class="px-4 py-3 border text-sm">
                                <a href="{{ route('alertes-articles.show', $alerte) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Voir les détails">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination professionnelle alignée à droite --}}
        <div class="mt-8 flex justify-end max-w-7xl mx-auto">
            <div class="inline-flex rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                @for ($page = 1; $page <= $alerteArticles->lastPage(); $page++)
                    <label class="relative">
                        <input type="radio" 
                               name="pagination" 
                               class="absolute inset-0 opacity-0 cursor-pointer"
                               @if ($alerteArticles->currentPage() == $page) checked @endif 
                               onchange="window.location='{{ $alerteArticles->url($page) }}'">
                        <span class="px-4 py-2.5 text-sm font-medium transition-all duration-200 cursor-pointer
                                    @if($alerteArticles->currentPage() == $page)
                                        bg-red-600 text-white
                                    @else
                                        bg-white text-gray-700 hover:bg-gray-50 hover:text-red-600
                                    @endif
                                    @if($page < $alerteArticles->lastPage()) border-r border-gray-200 @endif">
                            {{ $page }}
                        </span>
                    </label>
                @endfor
            </div>
        </div>
    @endif
@else
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Accès refusé',
            text: 'Vous n\'êtes pas autorisé à consulter cette page.',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endsection