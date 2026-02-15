@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 flex items-center border-b border-gray-200 pb-4">
        <i class="fa-solid fa-user-pen text-red-600 mr-3 text-2xl"></i>
        Modifier l'utilisateur
    </h1>

    @if (!auth()->user()->hasRole('admin'))
        <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-lg mb-6">
            <div class="flex items-start">
                <i class="fa-solid fa-circle-exclamation text-red-600 text-2xl mr-3 mt-1"></i>
                <div>
                    <p class="text-red-800 font-semibold text-lg">Accès refusé</p>
                    <p class="text-red-700 mt-1">Vous n'avez pas les droits nécessaires pour modifier un utilisateur.</p>
                    <a href="{{ route('users.index') }}" 
                       class="mt-4 inline-flex items-center text-red-600 hover:text-red-800 font-medium hover:underline">
                        <i class="fa-solid fa-arrow-left mr-1"></i>
                        Retour à la liste des utilisateurs
                    </a>
                </div>
            </div>
        </div>
    @else
        @if ($errors->any())
            <div class="mb-6 p-5 bg-red-50 text-red-700 rounded-xl border border-red-200 shadow-sm animate-shake">
                <div class="flex items-start">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 mt-0.5 mr-3 text-lg"></i>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('users.update', $user->user_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Grille 2 colonnes --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nom" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-signature text-red-500 mr-2"></i>
                        Nom <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}"
                            pattern="^[^,;:\.?!@&=%()$*#^{}<>+/]+$" 
                            title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                            class="mt-1 block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    </div>
                </div>

                <div>
                    <label for="nom_pseudo" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-user-shield text-purple-600 mr-2"></i>
                        Nom Pseudo <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-id-badge text-gray-400"></i>
                        </div>
                        <input type="text" name="nom_pseudo" id="nom_pseudo" value="{{ old('nom_pseudo', $user->nom_pseudo) }}"
                            pattern="^[^,;:\.?!@&=%()$*#^{}<>+/]+$" 
                            title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                            class="mt-1 block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    </div>
                </div>

                <div>
                    <label for="prenom" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-user-tag text-blue-600 mr-2"></i>
                        Prénom <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"
                            pattern="^[^,;:\.?!@&=%()$*#^{}<>+/]+$" 
                            title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"
                            class="mt-1 block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    </div>
                </div>

                <div>
                    <label for="adresse" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-location-dot text-green-600 mr-2"></i>
                        Adresse <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->adresse) }}"
                            pattern="^[^,;:\.?!@&=%()$*#^{}<>+/]+$" 
                            title="Ne doit pas contenir les caractères , ; : @ & ( ) $ * # ^ { } < > + /"                        
                            class="mt-1 block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    </div>
                </div>

                <div>
                    <label for="telephone" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-phone text-blue-600 mr-2"></i>
                        Téléphone <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-mobile-screen-button text-gray-400"></i>
                        </div>
                        <input type="tel" name="telephone" id="telephone"
                            value="{{ old('telephone', $user->telephone ?? '') }}"
                            pattern="^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$"
                            maxlength="8"
                            title="Numéro togolais valide : commence par 70 à 79 ou 90 à 99, et contient exactement 8 chiffres."
                            required
                            class="mt-1 block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    </div>
                </div>

                <div>
                    <label for="magasin_affecte" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-building text-indigo-600 mr-2"></i>
                        Magasin affecté <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-warehouse text-gray-400"></i>
                        </div>
                        <select name="magasin_affecte" id="magasin_affecte" required
                            class="mt-1 block w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all appearance-none bg-white">
                            <option value="">-- Choisir un magasin --</option>
                            <option value="collation" {{ old('magasin_affecte', $user->magasin_affecte) == 'collation' ? 'selected' : '' }}>Collation</option>
                            <option value="technique" {{ old('magasin_affecte', $user->magasin_affecte) == 'technique' ? 'selected' : '' }}>Technique</option>
                            <option value="admin" {{ old('magasin_affecte', $user->magasin_affecte) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-700">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-envelope text-yellow-500 mr-2"></i>
                        Email <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-at text-gray-400"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            pattern="^[^,;:\.?!&=%()$*#^{}<>+/]+$" 
                            title="Ne doit pas contenir les caractères , ; : & ( ) $ * # ^ { } < > + /"                        
                            class="mt-1 block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    </div>
                </div>

                {{-- Mot de passe avec œil --}}
                <div>
                    <label for="password" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-lock text-red-600 mr-2"></i>
                        Mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-key text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password"
                            oninput="handleInput('password', 'eyeIconPassword')"
                            class="mt-1 block w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                        <i id="eyeIconPassword"
                            class="fa-solid fa-eye-slash absolute right-3 top-3.5 cursor-pointer text-gray-500 hover:text-red-600 transition-colors"
                            style="display: none;"
                            onclick="togglePassword('password', 'eyeIconPassword')">
                        </i>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Laisser vide pour conserver l'actuel</p>
                </div>

                {{-- Confirmation mot de passe avec œil --}}
                <div>
                    <label for="password_confirmation" class="block font-medium text-gray-800 mb-2 flex items-center">
                        <i class="fa-solid fa-lock-check text-green-600 mr-2"></i>
                        Confirmer mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-key text-gray-400"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            oninput="handleInput('password_confirmation', 'eyeIconPasswordConfirm')"
                            class="mt-1 block w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                        <i id="eyeIconPasswordConfirm"
                            class="fa-solid fa-eye-slash absolute right-3 top-3.5 cursor-pointer text-gray-500 hover:text-red-600 transition-colors"
                            style="display: none;"
                            onclick="togglePassword('password_confirmation', 'eyeIconPasswordConfirm')">
                        </i>
                    </div>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('users.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Mettre à jour
                </button>
            </div>
        </form>

        <!-- Script pour les yeux -->
        <script>
            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                const isHidden = input.type === "password";
                input.type = isHidden ? "text" : "password";
                icon.className = isHidden
                    ? "fa-solid fa-eye absolute right-3 top-3.5 cursor-pointer text-red-600 hover:text-red-700 transition-colors"
                    : "fa-solid fa-eye-slash absolute right-3 top-3.5 cursor-pointer text-gray-500 hover:text-red-600 transition-colors";
            }

            function handleInput(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (input.value.length > 0) {
                    icon.style.display = "inline";
                } else {
                    icon.style.display = "none";
                    input.type = "password";
                    icon.className = "fa-solid fa-eye-slash absolute right-3 top-3.5 cursor-pointer text-gray-500 hover:text-red-600 transition-colors";
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