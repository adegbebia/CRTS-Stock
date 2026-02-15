@extends('layouts.app')
@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
        <div class="flex items-center mb-8 pb-4 border-b border-gray-200">
            <i class="fa-solid fa-file-lines text-red-600 text-3xl mr-4"></i>
            <h2 class="text-3xl font-bold text-gray-900">Génération de rapport produits</h2>
        </div>

        <form method="POST" action="{{ route('rapports-produits.generer') }}" class="space-y-6" id="rapportForm" target="_blank">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-800 mb-3 flex items-center">
                    <i class="fa-solid fa-layer-group text-blue-600 mr-2"></i>
                    Type de rapport <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="space-y-3 bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="radio" name="type" value="mois" required class="form-radio text-red-600 h-5 w-5 cursor-pointer" />
                            <div class="absolute inset-0 rounded-full border-2 border-red-600 opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        </div>
                        <span class="ml-3 text-gray-800 font-medium group-hover:text-red-600 transition-colors flex items-center">
                            <i class="fa-solid fa-calendar-days text-red-500 mr-2"></i>
                            Mensuel
                        </span>
                    </label>
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="radio" name="type" value="trimestre" class="form-radio text-red-600 h-5 w-5 cursor-pointer" />
                            <div class="absolute inset-0 rounded-full border-2 border-red-600 opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        </div>
                        <span class="ml-3 text-gray-800 font-medium group-hover:text-red-600 transition-colors flex items-center">
                            <i class="fa-solid fa-calendar-week text-green-600 mr-2"></i>
                            Trimestriel
                        </span>
                    </label>
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="radio" name="type" value="semestre" class="form-radio text-red-600 h-5 w-5 cursor-pointer" />
                            <div class="absolute inset-0 rounded-full border-2 border-red-600 opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        </div>
                        <span class="ml-3 text-gray-800 font-medium group-hover:text-red-600 transition-colors flex items-center">
                            <i class="fa-solid fa-calendar-range text-purple-600 mr-2"></i>
                            Semestriel
                        </span>
                    </label>
                </div>
            </div>

            <div id="divMois" class="hidden">
                <label for="mois" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-calendar-day text-red-500 mr-2"></i>
                    Choisir le mois <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="mois" id="mois"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ \DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                    @endfor
                </select>
            </div>

            <div id="divTrimestre" class="hidden">
                <label for="trimestre" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-calendar-week text-green-600 mr-2"></i>
                    Trimestre <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="trimestre" id="trimestre"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all">
                    <option value="1">1er trimestre (Janvier - Mars)</option>
                    <option value="2">2ème trimestre (Avril - Juin)</option>
                    <option value="3">3ème trimestre (Juillet - Septembre)</option>
                    <option value="4">4ème trimestre (Octobre - Décembre)</option>
                </select>
            </div>

            <div id="divSemestre" class="hidden">
                <label for="semestre" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-calendar-range text-purple-600 mr-2"></i>
                    Semestre <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="semestre" id="semestre"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all">
                    <option value="1">1er semestre (Janvier - Juin)</option>
                    <option value="2">2ème semestre (Juillet - Décembre)</option>
                </select>
            </div>

            <div>
                <label for="annee" class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-calendar-year text-blue-600 mr-2"></i>
                    Année <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="number" name="annee" id="annee" value="{{ date('Y') }}" required
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all">
            </div>

            <div class="pt-6 border-t border-gray-200">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center">
                    <i class="fa-solid fa-file-pdf mr-2 text-xl"></i>
                    Générer le rapport PDF
                </button>
                <p class="mt-3 text-xs text-gray-500 text-center italic">
                    Le rapport s'ouvrira dans un nouvel onglet
                </p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('input[name="type"]');
            const divMois = document.getElementById('divMois');
            const divTrimestre = document.getElementById('divTrimestre');
            const divSemestre = document.getElementById('divSemestre');

            function updateVisibility() {
                const selected = document.querySelector('input[name="type"]:checked');
                if (!selected) {
                    divMois.classList.add('hidden');
                    divTrimestre.classList.add('hidden');
                    divSemestre.classList.add('hidden');
                    return;
                }
                divMois.classList.toggle('hidden', selected.value !== 'mois');
                divTrimestre.classList.toggle('hidden', selected.value !== 'trimestre');
                divSemestre.classList.toggle('hidden', selected.value !== 'semestre');
            }

            radios.forEach(radio => {
                radio.addEventListener('change', updateVisibility);
            });

            updateVisibility();
        });
    </script>
@endsection