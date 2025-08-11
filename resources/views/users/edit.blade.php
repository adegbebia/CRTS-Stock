@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
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

        <form action="{{ route('users.update', $user->user_id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label for="nom_pseudo" class="block text-sm font-medium text-gray-700">Nom Pseudo :</label>
                <input type="text" name="nom_pseudo" id="nom_pseudo" value="{{ old('nom_pseudo', $user->nom_pseudo) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom :</label>
                <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse :</label>
                <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->adresse) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone :</label>
                <input type="tel" name="telephone" id="telephone"
                       value="{{ old('telephone', $user->telephone ?? '') }}"
                       pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$" maxlength="8"
                       title="Numéro togolais valide : commence par 70 à 79 ou 90 à 99, et contient exactement 8 chiffres."
                       required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label for="magasin_affecte" class="block text-sm font-medium text-gray-700">Magasin affecté :</label>
                <select name="magasin_affecte" id="magasin_affecte" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">-- Choisir un magasin --</option>
                    <option value="collation" {{ old('magasin_affecte', $user->magasin_affecte) == 'collation' ? 'selected' : '' }}>Collation</option>
                    <option value="technique" {{ old('magasin_affecte', $user->magasin_affecte) == 'technique' ? 'selected' : '' }}>Technique</option>
                    <option value="admin" {{ old('magasin_affecte', $user->magasin_affecte) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email :</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe :</label>
                <input type="password" name="password" id="password"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer mot de passe :</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="bg-red-300 text-black px-4 py-2 rounded hover:bg-red-500 transition">
                    Mettre à jour
                </button>
                <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    Retour à la liste
                </a>
            </div>
        </form>

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
