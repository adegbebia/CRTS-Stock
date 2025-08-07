<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des articles</title>

    <!-- SweetAlert CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <h2>Liste des articles dans la base</h2>
    @php
        $user = auth()->user();
    @endphp
    @if($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')

        <a href="{{ route('articles.create') }}">Ajouter un article</a>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                swal("Succès", "{{ session('success') }}", "success");
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                swal("Erreur", "{{ session('error') }}", "error");
            });
        </script>
    @endif
    <!-- @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: @json(session('success')),
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Accès refusé',
            text: @json(session('error')),
        });
    </script>
    @endif -->

    


    @if ($articles->isEmpty())
        <p>Aucun article enregistré pour le moment.</p>
    @else

    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('articles.index') }}" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Rechercher un article..." value="{{ request('search') }}">
        <button type="submit">Rechercher</button>
    </form>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Conditionnement</th>
                    <th>QtéStock</th>
                    <th>Stock max</th>
                    <th>Stock min</th>
                    <th>Stock sécurité</th>
                    <th>Date péremption</th>
                    <th>Lot</th>
                    <th>Date de création</th>
                    {{-- <th>Auteur</th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                <tr>
                    <td>{{ $article->codearticle }}</td>
                    <td>{{ $article->libelle }}</td>
                    <td>{{ $article->conditionnement }}</td>
                    <td>{{ $article->quantitestock }}</td>
                    <td>{{ $article->stockmax }}</td>
                    <td>{{ $article->stockmin }}</td>
                    <td>{{ $article->stocksecurite }}</td>
                    <td>{{ $article->dateperemption }}</td>
                    <td>{{ $article->lot }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($article->date)->translatedFormat('d F Y') }}
                    </td>
                    {{-- <td>{{ $article->user->nom ?? 'Inconnu' }}</td> --}}
                    <td>
                        <!-- Voir -->
                        <a href="{{ route('articles.show', $article->article_id) }}" title="Voir">
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

                        <!-- Modifier -->
                        @php
                            $user = auth()->user();
                        @endphp
                        @if($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation' && $article->user_id === $user->user_id)

                            <a href="{{ route('articles.edit', $article->article_id) }}" title="Modifier">
                                <button type="button">
                                    <!-- SVG original conservé -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
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

                            <!-- Supprimer avec SweetAlert -->
                            <form id="delete-form-{{ $article->article_id }}"
                                action="{{ route('articles.destroy', $article->article_id) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="confirmDelete('{{ $article->article_id }}')" title="Supprimer">
                                    <!-- SVG original conservé -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
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

                            <br>
                            <a href="{{ route('mouvements-articles.create', ['article' => $article->article_id]) }}">
                                <button type="button" title="Enregistrer un mouvement">
                                    📦 Mouvement
                                </button>
                            </a>
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Pagination --}}
    <div style="margin-top: 20px;">
        {{ $articles->links() }}
    </div>
    <div>
        <p><a href="{{ route('dashboard') }}">← Revenir au tableau de bord</a></p>
    </div>

    @endif

    <script>
        function confirmDelete(articleId) {
            swal({
                title: "Supprimer ?",
                text: "Cette action est irréversible !",
                icon: "warning",
                buttons: ["Annuler", "Oui, supprimer"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('delete-form-' + articleId).submit();
                }
            });
        }
    </script>

</body>

</html>
