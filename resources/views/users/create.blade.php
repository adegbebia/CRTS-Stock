@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">Créer un utilisateur</h1>

@php
    $user = auth()->user();
@endphp

@if ($user && $user->hasRole('admin'))

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div>
            <label for="nom" class="block font-medium text-gray-700">Nom :</label>
            <input type="text" name="nom" id="nom"
                value="{{ old('nom') }}"
                required pattern="[^,;:]+"
                title="Ne doit pas contenir les caractères , ; :"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label for="nom_pseudo" class="block font-medium text-gray-700">Nom Pseudo :</label>
            <input type="text" name="nom_pseudo" id="nom_pseudo"
                value="{{ old('nom_pseudo') }}"
                required pattern="[^,;:]+"
                title="Ne doit pas contenir les caractères , ; :"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label for="prenom" class="block font-medium text-gray-700">Prénom :</label>
            <input type="text" name="prenom" id="prenom"
                value="{{ old('prenom') }}"
                required pattern="[^,;:]+"
                title="Ne doit pas contenir les caractères , ; :"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label for="adresse" class="block font-medium text-gray-700">Adresse :</label>
            <input type="text" name="adresse" id="adresse"
                value="{{ old('adresse') }}"
                required pattern="[^,;:]+"
                title="Ne doit pas contenir les caractères , ; :"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label for="telephone" class="block font-medium text-gray-700">Téléphone :</label>
            <input type="tel" name="telephone" id="telephone"
                pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$"
                maxlength="8" required
                value="{{ old('telephone', isset($user) ? $user->telephone : '') }}"
                title="Numéro togolais valide : commence par 70 à 79 ou 90 à 99, et contient exactement 8 chiffres."
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label for="magasin_affecte" class="block font-medium text-gray-700">Magasin affecté :</label>
            <select name="magasin_affecte" id="magasin_affecte" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-300 focus:border-red-300">
                <option value="">-- Choisir un magasin ou rôle --</option>
                <option value="collation" {{ old('magasin_affecte') == 'collation' ? 'selected' : '' }}>Collation</option>
                <option value="technique" {{ old('magasin_affecte') == 'technique' ? 'selected' : '' }}>Technique</option>
                <option value="admin" {{ old('magasin_affecte') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div>
            <label for="email" class="block font-medium text-gray-700">Email :</label>
            <input type="email" name="email" id="email"
                value="{{ old('email') }}"
                required pattern="[^,;:]+"
                title="Ne doit pas contenir les caractères , ; :"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label for="password" class="block font-medium text-gray-700">Mot de passe :</label>
            <input type="password" name="password" id="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium text-gray-700">Confirmer mot de passe :</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-800 underline">Retour à la liste</a>
            <button type="submit" class="bg-red-300 hover:bg-red-500 text-black px-4 py-2 rounded-md shadow">
                Créer
            </button>
        </div>
    </form>

@else
    <p class="text-red-500 font-semibold">Vous n'êtes pas autorisé à accéder à cette page.</p>
    <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">Retour</a>
@endif

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

@endsection
