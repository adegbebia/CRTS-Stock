@extends('layouts.app')

@section('title', 'Liste des alertes articles')

@section('content')

    @php
        $user = auth()->user();
    @endphp
    
    @if($user->hasRole('admin') || ($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation'))

        <h1 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">Liste des alertes articles</h1>


        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($alerteArticles->isEmpty())
            <p>Aucune alerte à afficher.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200 rounded shadow">
                <thead>
                    <tr class="bg-red-200 text-left">
                        <th class="px-4 py-2 border-b border-gray-300">Articles</th>
                        <th class="px-4 py-2 border-b border-gray-300">Type d'alerte</th>
                        <th class="px-4 py-2 border-b border-gray-300">Date déclenchement</th>
                        <th class="px-4 py-2 border-b border-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alerteArticles as $alerte)
                        <tr class="hover:bg-gray-50 border-b border-gray-200">
                            <td class="px-4 py-2">{{ $alerte->article->libelle ?? 'Article inconnu' }}</td>
                            <td class="px-4 py-2">
                                @switch($alerte->typealerte)
                                    @case('Alerte rouge')
                                        <span class="text-red-600 font-semibold">Stock critique</span>
                                        @break
                                    @case('Alerte orange')
                                        <span class="text-orange-500 font-semibold">Stock faible</span>
                                        @break
                                    @case('Rupture de stock')
                                        <span class="text-yellow-500 font-semibold">Attention stock</span>
                                        @break
                                    @case('Alerte verte')
                                        <span class="text-green-600 font-semibold">Stock acceptable</span>
                                        @break
                                    @default
                                        <span class="text-gray-600 font-semibold">Article périmé</span>
                                @endswitch
                            </td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($alerte->datedeclenchement)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('alertes-articles.show', $alerte) }}" class="text-indigo-600 hover:underline" title="voir">
                                    <button type="button">
                                    <!-- SVG original conservé -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
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
            <div class="join mt-4 flex justify-end">
                @for ($page = 1; $page <= $alerteArticles->lastPage(); $page++)
                    <input type="radio" 
                        name="pagination" 
                        aria-label="{{ $page }}"
                        class="join-item btn btn-square bg-red-200 checked:bg-blue-500 checked:text-white"
                        @if ($alerteArticles->currentPage() == $page) checked @endif
                        onchange="window.location='{{ $alerteArticles->url($page) }}'" />
                @endfor
            </div>
        @endif
    @else
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Accès refusé',
                text: 'Vous n\'êtes pas autorisé à consulter cette page.',
            });
        </script>
    @endif
@endsection
