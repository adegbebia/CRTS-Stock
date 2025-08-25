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

        <form action="{{ route('users.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-6">
            @csrf


            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="nom" class="block font-medium text-gray-700">Nom :</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                        pattern="[^,;:?!=%@&()\$\*#\^{}<>+\/]+"
                        title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="telephone" class="block font-medium text-gray-700">Téléphone :</label>
                    <input type="tel" name="telephone" id="telephone"
                        pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$" maxlength="8"
                        required value="{{ old('telephone') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>


            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="prenom" class="block font-medium text-gray-700">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required
                        pattern="[^,;:?!@&()=%\$\*#\^{}<>+\/]+"
                        title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="adresse" class="block font-medium text-gray-700">Adresse :</label>
                    <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" required
                        pattern="[^,;:?!@&()=%\$\*#\^{}<>+\/]+"
                        title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>


            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="nom_pseudo" class="block font-medium text-gray-700">Nom Pseudo :</label>
                    <input type="text" name="nom_pseudo" id="nom_pseudo" value="{{ old('nom_pseudo') }}" required
                        pattern="[^,;:?!@&=%()\$\*#\^{}<>+\/]+"
                        title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                </div>
                <div>
                    <label for="password" class="block font-medium text-gray-700">Mot de passe :</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            oninput="handleInput('password', 'eyeIconPassword')"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        <i id="eyeIconPassword"
                            class="fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500"
                            style="display: none;" onclick="togglePassword('password', 'eyeIconPassword')">
                        </i>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-2 gap-6">

                <div>
                    <label for="email" class="block font-medium text-gray-700">Email :</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        pattern="[^,;:?!&()=%\$\*#\^{}<>+\/]+"
                        title="Ne doit pas contenir les caractères , ; :  & ( ) $ * # ^ { } < > + /"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                </div>
                <div>
                    <label for="password_confirmation" class="block font-medium text-gray-700">Confirmer mot de passe
                        :</label>
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


            <div class="flex justify-center">
                <div class="w-1/3">
                    <label for="magasin_affecte" class="block font-medium text-gray-700">Magasin affecté :</label>
                    <select name="magasin_affecte" id="magasin_affecte" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Choisir un magasin ou rôle --</option>
                        <option value="collation" {{ old('magasin_affecte') == 'collation' ? 'selected' : '' }}>Collation
                        </option>
                        <option value="technique" {{ old('magasin_affecte') == 'technique' ? 'selected' : '' }}>Technique
                        </option>
                        <option value="admin" {{ old('magasin_affecte') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>



            <!-- Boutons -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 bg-red-400 hover:bg-red-500 text-white rounded transition duration-200">
                    Retour à la liste
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-md shadow">
                    Créer
                </button>
            </div>
        </form>
    @else
        <p class="text-red-500 font-semibold">Vous n'êtes pas autorisé à accéder à cette page.</p>
        <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">Retour</a>
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Script pour voir/masquer le mot de passe -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            icon.className = isHidden ?
                "fa-solid fa-eye absolute right-3 top-3 cursor-pointer text-gray-500" :
                "fa-solid fa-eye-slash absolute right-3 top-3 cursor-pointer text-gray-500";
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

@endsection
