@extends('layouts.app')
@section('content')
@php
    $peutModifier =
        auth()->check() &&
        auth()->user()->hasRole('magasinier_collation') &&
        auth()->user()->magasin_affecte === 'collation';
@endphp

@php
    $user = auth()->user();

    // Permission de voir la page (admin OU magasinier_collation)
    $peutVoir = $user && (
        $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation'
        || $user->hasRole('admin')
    );

    // Permission de modifier (seulement magasinier_collation affecté au magasin collation)
    $peutModifier = $user && $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation';
@endphp

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
    <div class="flex items-center mb-8 pb-4 border-b border-gray-200">
        <i class="fa-solid fa-pen-to-square text-red-600 text-3xl mr-4"></i>
        <h2 class="text-3xl font-bold text-gray-900">Modifier la consommation (<span class="text-red-600">{{ $consommation->annee }}</span>)</h2>
    </div>

    @if (!$peutVoir)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-8">
            <div class="flex items-start">
                <i class="fa-solid fa-circle-exclamation text-red-600 text-xl mr-3 mt-0.5"></i>
                <p class="text-red-800 font-medium">⚠️ Vous n'êtes pas autorisé à modifier cette consommation.</p>
            </div>
        </div>
    @endif

    <form
        action="{{ $peutModifier ? route('consommations-articles.update', ['consommation_article' => $consommation->consommationArt_id]) : '#' }}"
        method="POST" @if (!$peutModifier) onsubmit="return false;" @endif>
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-bowl-food text-red-500 mr-2"></i>
                    Article <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="article_id" required @if (!$peutModifier) disabled @endif
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                   focus:ring-2 focus:ring-red-500 focus:border-red-500
                   text-gray-900 disabled:bg-gray-100 disabled:text-gray-500 transition-all">
                @foreach ($articles as $a)
                    <option value="{{ $a->article_id }}" {{ $a->article_id == $consommation->article_id ? 'selected' : '' }}>
                        {{ $a->libelle }}
                    </option>
                @endforeach
            </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fa-solid fa-calendar-year text-blue-600 mr-2"></i>
                    Année <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="number" name="annee" value="{{ $consommation->annee }}" min="2020" max="{{ date('Y') + 1 }}" 
                    required @if (!$peutModifier) disabled @endif
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm
                   focus:ring-2 focus:ring-red-500 focus:border-red-500
                   text-gray-900 disabled:bg-gray-100 disabled:text-gray-500 transition-all"
                   onwheel="event.preventDefault()">
            </div>
        </div>

        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-red-500 pb-2 flex items-center">
            <i class="fa-solid fa-calendar-days text-red-600 mr-2"></i>
            SORTIES MENSUELLES
        </h3>

        <div class="overflow-x-auto mb-8">
            <table class="min-w-full border border-gray-200 rounded-xl shadow-sm text-sm">
                <thead class="bg-gradient-to-r from-red-600 to-red-700 text-white">
                    <tr>
                        <th class="px-3 py-2 border-b border-red-800 font-bold text-xs uppercase tracking-wider">Mois</th>
                        @php
                            $mois = [
                                'janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin',
                                'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre'
                            ];
                        @endphp
                        @foreach ($mois as $m)
                            <th class="px-2 py-2 border-b border-red-800 font-bold text-xs uppercase tracking-wider">{{ ucfirst($m) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-3 py-2 border font-medium text-gray-800">Consommation</td>
                        @foreach ($mois as $m)
                            @php $val = $consommation['consommation_'.$m]; @endphp
                            <td class="px-2 py-2 border text-center font-semibold text-gray-900">
                                {{ $val }}
                                <input type="hidden" name="consommation_{{ $m }}" value="{{ $val }}">
                            </td>
                        @endforeach
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-3 py-2 border font-medium text-gray-800">Jours de rupture</td>
                        @foreach ($mois as $m)
                            @php $val = $consommation['rupture_'.$m]; @endphp
                            <td class="px-2 py-2 border text-center font-semibold text-red-600">
                                {{ $val }}
                                <input type="hidden" name="rupture_{{ $m }}" value="{{ $val }}">
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- @if ($peutModifier)
            <button type="submit"
                class="mt-6 px-3 py-1.5 bg-red-200 text-black text-sm rounded hover:bg-red-400
                focus:outline-none focus:ring-2 focus:ring-blue-300">
                Mettre à jour
            </button>
        @endif -->
    </form>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
@endsection