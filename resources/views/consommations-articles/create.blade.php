@extends('layouts.app')
@section('content')

    @php
        $user = auth()->user();

        // Permission de voir la page (admin OU magasinier_collation)
        $peutVoir = $user && (
            $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation'
            || $user->hasRole('admin')
        );

        // Permission de modifier (seulement magasinier_collation affecté au magasin collation)
        $peutModifier = $user && $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation';
    @endphp
    <h2 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">
        Nouvelle fiche de consommation

    </h2>

    @if (!$peutVoir)
        <p style="color:red;">⚠️ Vous n’êtes pas autorisé à créer ou modifier une fiche de consommation.</p>
    @endif

    <form action="{{ route('consommations-articles.store') }}" method="POST">
        @csrf

        <div>
            <label for="article_id" class="block text-sm font-medium text-gray-700 mb-1">Article :</label>
            <select name="article_id" id="article_id" required
                onchange="window.location.href='?article_id='+this.value+'&annee='+document.getElementById('annee').value;"
                class="block w-60 rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white text-gray-700 p-1.5 text-sm" >
                <option value="">-- Choisir un article --</option>
                @foreach ($articles as $article)
                    <option value="{{ $article->article_id }}"
                        {{ (isset($article_id) && $article_id == $article->article_id) || old('article_id') == $article->article_id ? 'selected' : '' }}>
                        {{ $article->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
        @php
            $user = auth()->user();
        @endphp

        {{-- @if ($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')

            <a href="{{ route('articles.create') }}" target="_blank">Ajouter un article</a>
            <p><em>Créez l’article puis actualisez cette page.</em></p>
        @endif --}}
        <div>
            <label for="annee" class="block text-sm font-medium text-gray-700 mb-1">Année :</label>
            <input type="number" name="annee" id="annee" min="2020" max="{{ date('Y') + 1 }}" required
                value="{{ $annee ?? old('annee', date('Y')) }}"
                onchange="window.location.href='?article_id='+document.getElementById('article_id').value+'&annee='+this.value;"
                class="block w-28 rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white text-gray-700 p-1.5 text-sm" 
                onwheel="event.preventDefault()">
        </div>

        <h3 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">SORTIE MENSUELLES</h3>
        <table class="min-w-full border border-gray-300 rounded-lg shadow text-sm" onwheel="event.preventDefault()">
            <thead class="bg-red-200 text-xs">
                <tr>
                    <th class="px-2 py-1 border">Mois</th>
                    @php
                        $mois = [
                            'janvier',
                            'fevrier',
                            'mars',
                            'avril',
                            'mai',
                            'juin',
                            'juillet',
                            'aout',
                            'septembre',
                            'octobre',
                            'novembre',
                            'decembre',
                        ];
                    @endphp
                    @foreach ($mois as $m)
                        <th class="px-1 py-1 border">{{ ucfirst($m) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-xs">
                <tr class="hover:bg-gray-50">
                    <td class="px-2 py-1 border">Consommation</td>
                    @foreach ($mois as $index => $m)
                        <td class="px-1 py-1 border">
                            {{ $consommations_mensuelles[$index + 1] ?? 0 }}
                            <input type="hidden" name="consommation_{{ $m }}"
                                value="{{ $consommations_mensuelles[$index + 1] ?? 0 }}">
                        </td>
                    @endforeach
                </tr>
                <tr class="hover:bg-gray-50"> 
                    <td class="px-2 py-1 border">Nombres De Jour de rupture</td>
                        @foreach ($mois as $index => $m)
                            <td class="px-1 py-1 border">
                                {{ $ruptures_mensuelles[$index + 1] ?? 0 }}
                                <input type="hidden" name="rupture_{{ $m }}"
                                    value="{{ $ruptures_mensuelles[$index + 1] ?? 0 }}">
                            </td>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($peutModifier)
            <div class="mt-4 flex justify-end">
                <button type="submit"
                    class="px-3 py-1.5 bg-red-200 text-black text-sm rounded hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Enregistrer
                </button>
            </div>
        @endif
    </form>

    <hr class="border-t-2 border-gray-300 my-6" />

    <h3 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">Consommations enregistrées</h3>
    {{--<form method="GET" action="{{ route('consommations-articles.create') }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par libellé article">
        <button type="submit">Rechercher</button>
    </form>--}}
    <form method="GET" action="{{ route('consommations-articles.create') }}" style="margin-bottom: 20px;">
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
    @if ($consommations->count())
        <table class="min-w-full border border-gray-300 rounded-lg shadow">
            <thead class="bg-red-200">
                <tr>
                    <th class="px-4 py-2 border">Article</th>
                    <th class="px-4 py-2 border">Année</th>
                    <th class="px-4 py-2 border">Total annuel</th>
                    <th class="px-4 py-2 border">Trimestre 1</th>
                    <th class="px-4 py-2 border">Trimestre 2</th>
                    <th class="px-4 py-2 border">Trimestre 3</th>
                    <th class="px-4 py-2 border">Trimestre 4</th>
                    <th class="px-4 py-2 border">Semestre 1</th>
                    <th class="px-4 py-2 border">Semestre 2</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consommations as $c)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $c->article->libelle ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">{{ $c->annee }}</td>
                        <td class="px-4 py-2 border">{{ $c->total_annuel }}</td>
                        <td class="px-4 py-2 border">{{ $c->trimestre1 }}</td>
                        <td class="px-4 py-2 border">{{ $c->trimestre2 }}</td>
                        <td class="px-4 py-2 border">{{ $c->trimestre3 }}</td>
                        <td class="px-4 py-2 border">{{ $c->trimestre4 }}</td>
                        <td class="px-4 py-2 border">{{ $c->semestre1 }}</td>
                        <td class="px-4 py-2 border">{{ $c->semestre2 }}</td>
                        <td class="px-4 py-2 border">
                            @if ($peutModifier)
                                <!-- <a href="{{ route('consommations-articles.edit', $c->consommationArt_id) }}"
                                    class="text-yellow-600 hover:underline" title="Modifier" title="Modifier">
                                    <button type="button" aria-label="Modifier">
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
                                </a> -->

                                <form id="delete-form-{{ $c->consommationArt_id }}"
                                    action="{{ route('consommations-articles.destroy', ['consommation_article' => $c->consommationArt_id]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $c->consommationArt_id }}')"
                                        class="text-red-600 hover:underline" title="Supprimer" aria-label="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                            @else
                                <em>Pas d'accès</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- <div>
            {{ $consommations->links() }}
        </div> -->
        <div class="join mt-4 flex justify-end">
            @for ($page = 1; $page <= $consommations->lastPage(); $page++)
                <input type="radio" name="pagination" aria-label="{{ $page }}"
                    class="join-item btn btn-square bg-red-200 checked:bg-blue-500 checked:text-white"
                    @if ($consommations->currentPage() == $page) checked @endif
                    onchange="window.location='{{ $consommations->url($page) }}'" />
            @endfor
        </div>
    @else
        <p>Aucune consommation enregistrée.</p>
    @endif

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Supprimer ?",
                text: "Cette action est irréversible !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
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
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif


@endsection
