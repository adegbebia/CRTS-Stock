@extends('layouts.app')



@section('content')
    <h2 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">
        Liste des Employés
    </h2>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @php
        $currentUser = auth()->user();
    @endphp

    {{-- Bouton créer uniquement pour admin --}}
    @if ($currentUser->hasRole('admin'))
        <div class="flex justify-end">
            <a href="{{ route('users.create') }}" class="bg-red-200 inline-flex items-center p-1 rounded hover:bg-gray-100"
                title="Ajouter un nouvel employé(é)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" width="20" height="20" class="text-red-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0
                                3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318
                                12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </a>
        </div>
    @endif
    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('users.index') }}" style="margin-bottom: 20px;">
        <label class="input inline-flex items-center border rounded px-2 py-1 mr-2">
            <svg class="h-5 w-5 opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
            <input name="search" type="search" required placeholder="Search" value="{{ request('search') }}"
                class="outline-none" />
        </label>
        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-red-300 transition"
            type="submit">Rechercher</button>
    </form>
    <table class="min-w-full border border-gray-300 rounded-lg shadow">
        <thead class="bg-red-200">
            <tr>
                <th class="px-4 py-2 border">Date de création Employé</th>
                <th class="px-4 py-2 border">Nom</th>
                <th class="px-4 py-2 border">Nom Pseudo </th>
                <th class="px-4 py-2 border">Prénom</th>
                <th class="px-4 py-2 border">Adresse</th>
                <th class="px-4 py-2 border">Téléphone</th>
                <th class="px-4 py-2 border">Magasin Affecté</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($user->datecreation)->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-4 py-2 border">{{ $user->nom }}</td>
                    <td class="px-4 py-2 border">{{ $user->nom_pseudo }}</td>
                    <td class="px-4 py-2 border">{{ $user->prenom }}</td>
                    <td class="px-4 py-2 border">{{ $user->adresse }}</td>
                    <td class="px-4 py-2 border">{{ $user->telephone }}</td>
                    <td class="px-4 py-2 border">{{ $user->magasin_affecte }}</td>
                    <td class="px-4 py-2 border">{{ $user->email }}</td>
                    <td class="px-4 py-2 border">
                        {{-- Tout le monde peut voir --}}
                        <a href="{{ route('users.show', $user->user_id) }}" class="text-indigo-600 hover:underline"
                            title="Voir">
                            <button type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    width="20" height="20">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                    <path fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </a>

                        {{-- Modifier et Supprimer uniquement pour admin --}}
                        @if ($currentUser->hasRole('admin'))
                            <a href="{{ route('users.edit', $user->user_id) }}" class="text-yellow-600 hover:underline"
                                title="Modifier">
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        width="20" height="20">
                                        <path
                                            d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                        <path
                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                    </svg>
                                </button>
                            </a>

                            <form action="{{ route('users.destroy', $user->user_id) }}" method="POST"
                                style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete text-red-500 hover:underline " title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        width="20" height="20">
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
                <tr>
                    <td colspan="7">Aucun employé trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="join mt-4 flex justify-end">
        @for ($page = 1; $page <= $users->lastPage(); $page++)
            <input type="radio" name="pagination" aria-label="{{ $page }}"
                class="join-item btn btn-square bg-red-200 checked:bg-blue-500 checked:text-white"
                @if ($users->currentPage() == $page) checked @endif onchange="window.location='{{ $users->url($page) }}'" />
        @endfor
    </div>



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

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                swal("Succès", "{{ session('success') }}", "success");
            });
        </script>
    @endif

    @if ($errors->has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                swal("Erreur", "{{ $errors->first('error') }}", "error");
            });
        </script>
    @endif
@endsection
