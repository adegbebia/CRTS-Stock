<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des employés</title>
</head>
<body>
    <h1>Liste des Employés</h1>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @php
        $currentUser = auth()->user();
    @endphp

    {{-- Bouton créer uniquement pour admin --}}
    @if ($currentUser->hasRole('admin'))
        <a href="{{ route('users.create') }}" title="Ajouter un nouvel employé(é)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                width="20" height="20">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0
                        3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318
                        12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
            </svg>
        </a>

    @endif
        {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('users.index')}}" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Rechercher un employer..." value="{{ request('search') }}">
        <button type="submit">Rechercher</button>
    </form>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Date de création Employé</th>
                <th>Nom</th>
                <th>Nom Pseudo </th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Magasin Affecté</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($user->datecreation)->translatedFormat('d F Y') }}</td>
                    <td>{{ $user->nom }}</td>
                    <td>{{ $user->nom_pseudo }}</td>
                    <td>{{ $user->prenom }}</td>
                    <td>{{ $user->adresse }}</td>
                    <td>{{ $user->telephone }}</td>
                    <td>{{ $user->magasin_affecte }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{-- Tout le monde peut voir --}}
                        <a href="{{ route('users.show', $user->user_id) }}" title="Voir">
                            <button type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" width="20" height="20">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                    <path fill-rule="evenodd"
                                          d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>
                        </a>

                        {{-- Modifier et Supprimer uniquement pour admin --}}
                        @if ($currentUser->hasRole('admin'))
                            <a href="{{ route('users.edit', $user->user_id) }}" title="Modifier">
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                         fill="currentColor" width="20" height="20">
                                        <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                    </svg>
                                </button>
                            </a>

                            <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                         fill="currentColor" width="20" height="20">
                                        <path fill-rule="evenodd"
                                              d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Aucun employé trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $users->links() }}

    

    {{-- SweetAlert pour confirmation suppression --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                swal({
                    title: "Êtes-vous sûr ?",
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: "warning",
                    buttons: ["Annuler", "Oui, supprimer !"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                swal("Succès", "{{ session('success') }}", "success");
            });
        </script>
    @endif

    @if($errors->has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                swal("Erreur", "{{ $errors->first('error') }}", "error");
            });
        </script>
    @endif
</body>
</html>
