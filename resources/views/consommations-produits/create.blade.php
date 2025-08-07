<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consommations – Création</title>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    @php
        // Définir la variable de permission selon ton besoin réel
        $peutModifier =
            auth()->check() &&
            auth()->user()->hasRole('magasinier_technique') &&
            auth()->user()->magasin_affecte === 'technique';
    @endphp

    <h2>Nouvelle fiche de consommation</h2>

    @if (!$peutModifier)
        <p style="color:red;">⚠️ Vous n’êtes pas autorisé à créer ou modifier une fiche de consommation.</p>
    @endif


    <form action="{{ route('consommations-produits.store') }}" method="POST">
        @csrf

        <label for="produit_id">Produit :</label>
        <select name="produit_id" id="produit_id" required
            onchange="window.location.href='?produit_id='+this.value+'&annee='+document.getElementById('annee').value;">
            <option value="">-- Choisir un produit --</option>
            @foreach ($produits as $produit)
                <option value="{{ $produit->produit_id }}"
                    {{ isset($produit_id) && $produit_id == $produit->produit_id ? 'selected' : (old('produit_id') == $produit->produit_id ? 'selected' : '') }}>
                    {{ $produit->libelle }}
                </option>
            @endforeach
        </select>
        @php
            $user = auth()->user();
        @endphp
        {{-- @if ($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')
            <a href="{{ route('produits.create') }}">Ajouter un produit</a>
            <p><em>Créez le produit puis actualisez cette page.</em></p>

        @endif --}}
        <!-- <a href="{{ route('produits.create') }}" target="_blank">Ajouter un produit</a>
        <p><em>Créez le produit puis actualisez cette page.</em></p> -->

        <label for="annee">Année :</label>
        <input type="number" name="annee" id="annee" min="2020" max="{{ date('Y') + 1 }}" required
            value="{{ $annee ?? old('annee', date('Y')) }}"
            onchange="window.location.href='?produit_id='+document.getElementById('produit_id').value+'&annee='+this.value;">

        <h3>SORTIE MENSUELLES</h3>
        <table border="1" cellpadding="4" cellspacing="0">
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
                    @foreach ($mois as $index => $m)
                        <td>
                            {{ $consommations_mensuelles[$index + 1] ?? 0 }}
                            <input type="hidden" name="consommation_{{ $m }}"
                                value="{{ $consommations_mensuelles[$index + 1] ?? 0 }}">
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Jours de rupture</td>
                    @foreach ($mois as $m)
                        <td>
                            <input type="number" name="rupture_{{ $m }}" min="0"
                                value="{{ old('rupture_' . $m, 0) }}" required>
                            @if (!$peutModifier)
                                disabled
                            @endif

                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        @if ($peutModifier)
            <button type="submit">Enregistrer</button>
        @endif
    </form>

    <hr>

    <h3>Consommations enregistrées</h3>
    <form method="GET" action="{{ route('consommations-produits.create') }}">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Rechercher par libellé produit">
        <button type="submit">Rechercher</button>
    </form>


    @if ($consommations->count())
        <table border="1" cellpadding="4" cellspacing="0">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Année</th>
                    <th>Total annuel</th>
                    <th>Trimestre 1</th>
                    <th>Trimestre 2</th>
                    <th>Trimestre 3</th>
                    <th>Trimestre 4</th>
                    <th>Semestre 1</th>
                    <th>Semestre 2</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consommations as $c)
                    <tr>
                        <td>{{ $c->produit->libelle ?? 'N/A' }}</td>
                        <td>{{ $c->annee }}</td>
                        <td>{{ $c->total_annuel }}</td>
                        <td>{{ $c->trimestre1 }}</td>
                        <td>{{ $c->trimestre2 }}</td>
                        <td>{{ $c->trimestre3 }}</td>
                        <td>{{ $c->trimestre4 }}</td>
                        <td>{{ $c->semestre1 }}</td>
                        <td>{{ $c->semestre2 }}</td>
                        <td>
                            @if ($peutModifier)
                                <a href="{{ route('consommations-produits.edit', $c->consommationProd_id) }}"
                                    title="Modifier">
                                    <button type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1
                            2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897
                            1.13L6 18l.8-2.685a4.5 4.5 0 0 1
                            1.13-1.897l8.932-8.931Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0 1
                            15.75 21H5.25A2.25 2.25 0 0 1
                            3 18.75V8.25A2.25 2.25 0 0 1
                            5.25 6H10" />
                                        </svg>
                                    </button>
                                </a>

                                <!-- Suppression avec confirmation SweetAlert -->
                                <form id="delete-form-{{ $c->consommationProd_id }}"
                                    action="{{ route('consommations-produits.destroy', ['consommations_produit' => $c->consommationProd_id]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $c->consommationProd_id }}')"
                                        title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107
                                            1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0
                                            1-2.244 2.077H8.084a2.25 2.25 0 0
                                            1-2.244-2.077L4.772 5.79m14.456 0a48.108
                                            48.108 0 0 0-3.478-.397m-12
                                            .562c.34-.059.68-.114 1.022-.165m0
                                            0a48.11 48.11 0 0 1 3.478-.397m7.5
                                            0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964
                                            51.964 0 0 0-3.32 0c-1.18.037-2.09
                                            1.022-2.09 2.201v.916m7.5 0a48.667
                                            48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <em>Pas d'accès</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $consommations->links() }}
        </div>
        <div>
            <p><a href="{{ route('dashboard') }}">← Revenir au tableau de bord</a></p>
        </div>
    @else
        <p>Aucune consommation enregistrée.</p>
    @endif

    <!-- SweetAlert Suppression -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Supprimer ?",
                text: "Cette action est irréversible !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Oui, supprimer",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

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

</body>

</html>
