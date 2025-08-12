@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Modifier un utilisateur</h1>

    @if (!auth()->user()->hasRole('admin'))
        <p class="text-red-600 font-semibold mb-4">
            Accès refusé : vous n'avez pas les droits nécessaires pour modifier un utilisateur.
        </p>
        <a href="{{ route('users.index') }}" class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
            Retour à la liste
        </a>
    @else
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->user_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Grille 2 colonnes --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nom" class="block font-medium text-gray-700">Nom :</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="nom_pseudo" class="block font-medium text-gray-700">Nom Pseudo :</label>
                    <input type="text" name="nom_pseudo" id="nom_pseudo" value="{{ old('nom_pseudo', $user->nom_pseudo) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="prenom" class="block font-medium text-gray-700">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="adresse" class="block font-medium text-gray-700">Adresse :</label>
                    <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->adresse) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="telephone" class="block font-medium text-gray-700">Téléphone :</label>
                    <input type="tel" name="telephone" id="telephone"
                        value="{{ old('telephone', $user->telephone ?? '') }}"
                        pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$"
                        maxlength="8"
                        title="Numéro togolais valide : commence par 70 à 79 ou 90 à 99, et contient exactement 8 chiffres."
                        required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="magasin_affecte" class="block font-medium text-gray-700">Magasin affecté :</label>
                    <select name="magasin_affecte" id="magasin_affecte" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        <option value="">-- Choisir un magasin --</option>
                        <option value="collation" {{ old('magasin_affecte', $user->magasin_affecte) == 'collation' ? 'selected' : '' }}>Collation</option>
                        <option value="technique" {{ old('magasin_affecte', $user->magasin_affecte) == 'technique' ? 'selected' : '' }}>Technique</option>
                        <option value="admin" {{ old('magasin_affecte', $user->magasin_affecte) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div>
                    <label for="email" class="block font-medium text-gray-700">Email :</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                {{-- Mot de passe avec œil --}}
                <div>
                    <label for="password" class="block font-medium text-gray-700">Mot de passe :</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            oninput="handleInput('password', 'eyeIconPassword')"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        <i id="eyeIconPassword"
                            class="fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500"
                            style="display: none;"
                            onclick="togglePassword('password', 'eyeIconPassword')">
                        </i>
                    </div>
                </div>

                {{-- Confirmation mot de passe avec œil --}}
                <div>
                    <label for="password_confirmation" class="block font-medium text-gray-700">Confirmer mot de passe :</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            oninput="handleInput('password_confirmation', 'eyeIconPasswordConfirm')"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        <i id="eyeIconPasswordConfirm"
                            class="fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500"
                            style="display: none;"
                            onclick="togglePassword('password_confirmation', 'eyeIconPasswordConfirm')">
                        </i>
                    </div>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded shadow">
                    Mettre à jour
                </button>
                <a href="{{ route('users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded shadow">
                    Retour à la liste
                </a>
            </div>
        </form>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Script pour les yeux -->
        <script>
            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                const isHidden = input.type === "password";
                input.type = isHidden ? "text" : "password";
                icon.className = isHidden
                    ? "fa-solid fa-eye absolute right-3 top-3 cursor-pointer text-gray-500"
                    : "fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500";
            }

            function handleInput(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (input.value.length > 0) {
                    icon.style.display = "inline";
                } else {
                    icon.style.display = "none";
                    input.type = "password";
                    icon.className = "fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500";
                }
            }
        </script>

        <!-- SweetAlert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    @endif
</div>
@endsection
