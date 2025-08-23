@extends('layouts.app')
@section('content')
    @php
        $user = auth()->user();

        // Permission de voir la page (admin OU magasinier_technique)
        $peutVoir = $user && (
            $user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique'
            || $user->hasRole('admin')
        );

        // Permission de modifier (seulement magasinier_technique affecté au magasin technique)
        $peutModifier = $user && $user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique';
    @endphp

    <h2 class="text-3xl font-bl text-gray-800 mb-6 border-b-4 border-blue-500 pb-2">
        Modifier la consommation ({{ $consommation->annee }})
    </h2>

    @if (!$peutVoir)
        <p class="text-red-600 mb-4">⚠️ Vous n’êtes pas autorisé à modifier cette consommation.</p>
    @endif

    <form
        action="{{ $peutModifier ? route('consommations-produits.update', ['consommations_produit' => $consommation->consommationProd_id]) : '#' }}"
        method="POST" @if (!$peutModifier) onsubmit="return false;" @endif>
        @csrf
        @method('PUT')

        <div class="mb-6 max-w-xs">
            <label class="block text-sm font-medium text-gray-700 mb-1">Produit :</label>
            <select name="produit_id" required @if (!$peutModifier) disabled @endif
                class="block w-40 rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm
               focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:ring-opacity-50
               text-gray-900 disabled:bg-gray-100 disabled:text-gray-500">
                @foreach ($produits as $p)
                    <option value="{{ $p->produit_id }}" {{ $p->produit_id == $consommation->produit_id ? 'selected' : '' }}>
                        {{ $p->libelle }}
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

        <div class="overflow-x-auto">
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
        </div>

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
