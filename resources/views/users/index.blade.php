@extends('layouts.app')

@section('content')
    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-4 border-red-600 pb-2 flex items-center">
        <i class="fa-solid fa-users-gear text-red-600 mr-3 text-2xl hidden md:inline"></i>
        Liste des Employés
    </h2>

    @if (session('success'))
        <div class="bg-green-50 text-green-700 border-l-4 border-green-500 p-3 rounded-r mb-6 flex items-start">
            <i class="fa-solid fa-circle-check text-green-600 mt-0.5 mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @php
        $currentUser = auth()->user();
    @endphp

    {{-- Bouton créer uniquement pour admin --}}
    @if ($currentUser->hasRole('admin'))
        <div class="flex justify-end mb-5">
            <a href="{{ route('users.create') }}" 
               class="bg-red-600 hover:bg-red-700 inline-flex items-center p-2 rounded-lg text-white transition-all shadow-md hover:shadow-lg"
               title="Ajouter un nouvel employé">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" width="20" height="20" class="text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0
                                3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318
                                12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </a>
        </div>
    @endif
    
    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('users.index') }}" class="mb-6 flex flex-col sm:flex-row gap-3">
        <label class="input inline-flex items-center border border-gray-300 rounded-lg px-3 py-2 bg-white focus-within:ring-2 focus-within:ring-red-500 focus-within:border-red-500 transition-all flex-1 max-w-md">
            <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
            <input name="search" type="search" placeholder="Rechercher un employé..." value="{{ request('search') }}"
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
            <thead class="bg-red-600">
                <tr>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Date création</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Nom</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Nom Pseudo</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Prénom</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Adresse</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Téléphone</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Magasin</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ \Carbon\Carbon::parse($user->datecreation)->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-3 border text-sm font-medium text-gray-900">{{ $user->nom }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $user->nom_pseudo }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $user->prenom }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $user->adresse }}</td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $user->telephone }}</td>
                        <td class="px-4 py-3 border text-sm">
                            <span class="px-2.5 py-1 inline-flex text-xs font-medium rounded-full 
                                @if($user->magasin_affecte === 'admin') bg-blue-100 text-blue-800
                                @elseif($user->magasin_affecte === 'technique') bg-red-100 text-red-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($user->magasin_affecte) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 border text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-4 py-3 border text-sm font-medium space-x-2">
                            {{-- Tout le monde peut voir --}}
                            <a href="{{ route('users.show', $user->user_id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Voir">
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </a>

                            {{-- Modifier et Supprimer uniquement pour admin --}}
                            @if ($currentUser->hasRole('admin'))
                                <a href="{{ route('users.edit', $user->user_id) }}" class="text-amber-600 hover:text-amber-800 transition-colors" title="Modifier">
                                    <button type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                                            <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                        </svg>
                                    </button>
                                </a>

                                <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete text-red-600 hover:text-red-800 transition-colors" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500 italic">
                            Aucun employé trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Remplacez votre section pagination existante par ce code -->
    <div class="mt-6 flex justify-end">
    <div class="inline-flex rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @for ($page = 1; $page <= $users->lastPage(); $page++)
            <label class="relative">
                <input type="radio" 
                        name="pagination" 
                        class="absolute inset-0 opacity-0 cursor-pointer"
                        @if ($users->currentPage() == $page) checked @endif 
                        onchange="window.location='{{ $users->url($page) }}'">
                <span class="px-4 py-2.5 text-sm font-medium transition-all duration-200 cursor-pointer
                            @if($users->currentPage() == $page)
                                bg-red-600 text-white
                            @else
                                bg-white text-gray-700 hover:bg-gray-50 hover:text-red-600
                            @endif
                            @if($page < $users->lastPage()) border-r border-gray-200 @endif">
                    {{ $page }}
                </span>
            </label>
        @endfor
    </div>
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