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
                    <th class="px-4 py-3 border-b border-red-700 text-left text-xs font-bold text-white uppercase tracking-wider">Statut</th>
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
                        <td class="px-4 py-3 border text-sm text-center">
                            @if($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fa-solid fa-toggle-on mr-1"></i>
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fa-solid fa-toggle-off mr-1"></i>
                                    Désactivé
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 border text-sm font-medium space-x-2">
                            {{-- Voir --}}
                            <a href="{{ route('users.show', $user->user_id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Voir les détails">
                                <i class="fa-solid fa-eye text-lg"></i>
                            </a>

                            {{-- Modifier et Gérer le statut --}}
                            @if ($currentUser->hasRole('admin'))
                                <a href="{{ route('users.edit', $user->user_id) }}" class="text-amber-600 hover:text-amber-800 transition-colors" title="Modifier">
                                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                                </a>

                                {{-- TOGGLE DYNAMIQUE : Désactiver ou Réactiver --}}
                                @if($user->is_active)
                                    {{-- BOUTON DÉSACTIVER (vert) --}}
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline;" id="deactivate-form-{{ $user->user_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="deactivation_reason" id="deactivation_reason_{{ $user->user_id }}">
                                        <button type="button" 
                                                class="text-green-600 hover:text-green-800 transition-colors" 
                                                title="Désactiver (bloque l'accès mais conserve l'historique)" 
                                                onclick="confirmDeactivation({{ $user->user_id }})">
                                            <i class="fa-solid fa-toggle-on text-xl"></i>
                                        </button>
                                    </form>
                                @else
                                    {{-- BOUTON RÉACTIVER (rouge) --}}
                                    <form action="{{ route('users.restore', $user->user_id) }}" method="POST" style="display:inline;" id="restore-form-{{ $user->user_id }}">
                                        @csrf
                                        <button type="button" 
                                                class="text-red-600 hover:text-red-800 transition-colors" 
                                                title="Réactiver cet utilisateur" 
                                                onclick="confirmRestore({{ $user->user_id }})">
                                            <i class="fa-solid fa-toggle-off text-xl"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center text-gray-500 italic">
                            Aucun employé trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

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

    {{-- SweetAlert pour confirmation --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function confirmDeactivation(userId) {
            swal({
                title: "Désactiver cet utilisateur ?",
                text: "Cette action bloquera immédiatement son accès au système mais conservera tout son historique (produits, mouvements, alertes) pour l'audit sanitaire.\n\nVeuillez indiquer le motif obligatoire (min. 10 caractères) :",
                content: "input",
                buttons: {
                    cancel: "Annuler",
                    confirm: {
                        text: "Désactiver",
                        value: true,
                        className: "bg-red-600 hover:bg-red-700 text-white",
                    }
                },
                dangerMode: true,
                closeOnEsc: false,
                closeOnClickOutside: false,
            })
            .then((reason) => {
                if (reason === null) {
                    return false;
                }
                const trimmed = reason.trim();
                if (trimmed.length < 10) {
                    swal("Motif invalide", "Le motif doit contenir au moins 10 caractères pour la traçabilité sanitaire (ex: départ, licenciement, mutation).", "error");
                    return false;
                }
                document.getElementById('deactivation_reason_' + userId).value = trimmed;
                document.getElementById('deactivate-form-' + userId).submit();
            });
        }

        function confirmRestore(userId) {
            swal({
                title: "Réactiver cet utilisateur ?",
                text: "Cette action restaurera immédiatement l'accès au compte et changera son statut en 'Actif'.",
                buttons: {
                    cancel: "Annuler",
                    confirm: {
                        text: "Réactiver",
                        value: true,
                        className: "bg-green-600 hover:bg-green-700 text-white",
                    }
                },
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false,
            })
            .then((willRestore) => {
                if (willRestore) {
                    document.getElementById('restore-form-' + userId).submit();
                }
            });
        }
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