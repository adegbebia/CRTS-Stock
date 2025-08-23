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

        // Permission de modifier (seulement magasinier_collation affecté au magasinier_collation technique)
        $peutModifier = $user && $user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation';
    @endphp

    <h2 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">Modifier la consommation ({{ $consommation->annee }})</h2>
    @if (!$peutVoir)
        <p class="text-red-600 mb-4">⚠️ Vous n’êtes pas autorisé à modifier cette consommation.</p>
    @endif
    <form
        action="{{ $peutModifier ? route('consommations-articles.update', ['consommation_article' => $consommation->consommationArt_id]) : '#' }}"
        method="POST" @if (!$peutModifier) onsubmit="return false;" @endif>
        @csrf
        @method('PUT')

        <div class="mb-6 max-w-xs">
            <label class="block text-sm font-medium text-gray-700 mb-1">Article :</label>
            <select name="article_id" required @if (!$peutModifier) disabled @endif
                class="block w-40 rounded-md border border-gray-300 bg-white px-100 py-2 shadow-sm
               focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:ring-opacity-50
               text-gray-900 disabled:bg-gray-100 disabled:text-gray-500">
            @foreach ($articles as $a)
                <option value="{{ $a->article_id }}" {{ $a->article_id == $consommation->article_id ? 'selected' : '' }}>
                    {{ $a->libelle }}
                </option>
            @endforeach
        </select>
        </div>
        

        <div class="mb-6 max-w-xs">
            <label class="block text-sm font-medium text-gray-700 mb-1">Année :</label>
            <input type="number" name="annee" value="{{ $consommation->annee }}" min="2020" max="{{ date('Y') + 1 }}" 
                required @if (!$peutModifier) disabled @endif
                class="block w-28 rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
               focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:ring-opacity-50
               text-gray-900 disabled:bg-gray-100 disabled:text-gray-500"
               onwheel="event.preventDefault()">
        </div>
        

        <h3 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">SORTIE MENSUELLES</h3>
        <table class="min-w-full border border-gray-300 rounded-lg shadow text-sm" onwheel="event.preventDefault()">
            <thead class="bg-red-200 text-xs">
                <tr>
                    <th class="px-2 py-1 border"></th>
                    @php
                        $mois = [
                            'janvier',
                            'fevrier',
                            'mars',
                            'avril',
                            'mai',
                            'juin',
                            'juillet',
                            'aout',
                            'septembre',
                            'octobre',
                            'novembre',
                            'decembre',
                        ];
                    @endphp
                    @foreach ($mois as $m)
                        <th class="px-1 py-1 border">{{ ucfirst($m) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-xs">
                <tr class="hover:bg-gray-50">
                    <td class="px-2 py-1 border">Consommation</td>
                    @foreach ($mois as $m)
                        @php $val = $consommation['consommation_'.$m]; @endphp
                        <td class="px-1 py-1 border">
                            {{ $val }}
                            <input type="hidden" name="consommation_{{ $m }}" value="{{ $val }}">
                        </td>
                    @endforeach
                </tr>
                <tr class="hover:bg-gray-50">
                        <td class="px-2 py-1 border">Nombres De Jour de rupture</td>
                        @foreach ($mois as $m)
                            @php $val = $consommation['rupture_'.$m]; @endphp
                            <td class="px-1 py-1 border">
                                {{ $val }}
                                <input type="hidden" name="rupture_{{ $m }}" value="{{ $val }}">
                            </td>
                        @endforeach
                </tr>
            </tbody>
        </table>
        <!-- @if ($peutModifier)
            <button type="submit"
                class="mt-6 px-3 py-1.5 bg-red-200 text-black text-sm rounded hover:bg-red-400
                focus:outline-none focus:ring-2 focus:ring-blue-300">
                Mettre à jour
            </button>
        @endif -->
    </form>

    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: {!! json_encode(session('success')) !!},
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
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endsection
