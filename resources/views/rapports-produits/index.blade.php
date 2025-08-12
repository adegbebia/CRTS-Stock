@extends('layouts.app')
@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Génération de rapport</h2>

        <form method="POST" action="{{ route('rapports-produits.generer') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type de rapport :</label>
                <div class="flex flex-col space-y-2 text-gray-700">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="mois" required class="form-radio text-red-600">
                        <span class="ml-2">Mensuel</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="trimestre" class="form-radio text-red-600">
                        <span class="ml-2">Trimestriel</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="semestre" class="form-radio text-red-600">
                        <span class="ml-2">Semestriel</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="mois" class="block text-sm font-medium text-gray-700 mb-1">Choisir le mois :</label>
                <select name="mois" id="mois"
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                           focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="trimestre" class="block text-sm font-medium text-gray-700 mb-1">Trimestre :</label>
                <select name="trimestre" id="trimestre"
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                           focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900">
                    <option value="1">1 (Janv-Mars)</option>
                    <option value="2">2 (Avr-Juin)</option>
                    <option value="3">3 (Juil-Sept)</option>
                    <option value="4">4 (Oct-Déc)</option>
                </select>
            </div>

            <div>
                <label for="semestre" class="block text-sm font-medium text-gray-700 mb-1">Semestre :</label>
                <select name="semestre" id="semestre"
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                           focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900">
                    <option value="1">1 (Janv-Juin)</option>
                    <option value="2">2 (Juil-Déc)</option>
                </select>
            </div>

            <div>
                <label for="annee" class="block text-sm font-medium text-gray-700 mb-1">Année :</label>
                <input type="number" name="annee" id="annee" value="{{ date('Y') }}" required
                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
                           focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-900">
            </div>

            <div class="pt-4">
                <input type="submit" value="Générer le rapport"
                    class="w-full bg-red-600 text-white font-semibold py-2 rounded hover:bg-red-700
                           focus:outline-none focus:ring-2 focus:ring-red-400 cursor-pointer">
            </div>
        </form>

        @if (session('pdf'))
            <p class="mt-6 text-center">
                <a href="{{ session('pdf') }}" class="text-blue-600 hover:underline inline-flex items-center justify-center">
                    📄 Télécharger le rapport généré
                </a>
            </p>
        @endif
    </div>
@endsection
