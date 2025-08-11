@extends('layouts.app')
@section('content')
    @php
        $peutModifier =
            auth()->check() &&
            auth()->user()->hasRole('magasinier_collation') &&
            auth()->user()->magasin_affecte === 'collation';
    @endphp

    <h2>Modifier la consommation ({{ $consommation->annee }})</h2>
    @if (!$peutModifier)
        <p style="color:red;">⚠️ Vous n’êtes pas autorisé à modifier cette consommation.</p>
    @endif
    <form
        action="{{ $peutModifier ? route('consommations-articles.update', ['consommation_article' => $consommation->consommationArt_id]) : '#' }}"
        method="POST" @if (!$peutModifier) onsubmit="return false;" @endif>
        @csrf
        @method('PUT')

        <label>Article :</label>
        <select name="article_id" required @if (!$peutModifier) disabled @endif>
            @foreach ($articles as $a)
                <option value="{{ $a->article_id }}" {{ $a->article_id == $consommation->article_id ? 'selected' : '' }}>
                    {{ $a->libelle }}
                </option>
            @endforeach
        </select>

        <label>Année :</label>
        <input type="number" name="annee" value="{{ $consommation->annee }}" min="2020" max="{{ date('Y') + 1 }}"
            required>

        <h3>SORTIE MENSUELLES</h3>
        <table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th>Mois</th>
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
                        <th>{{ ucfirst($m) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Consommation</td>
                    @foreach ($mois as $m)
                        @php $val = $consommation['consommation_'.$m]; @endphp
                        <td>
                            {{ $val }}
                            <input type="hidden" name="consommation_{{ $m }}" value="{{ $val }}">
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Jours de rupture</td>
                    @foreach ($mois as $m)
                        <td>
                            <input type="number" name="rupture_{{ $m }}" min="0"
                                value="{{ $consommation['rupture_' . $m] }}" required>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        @if ($peutModifier)
            <button type="submit">Mettre à jour</button>
        @endif
    </form>

    <p><a href="{{ route('consommations-articles.index') }}">← Retour à la liste</a></p>

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
