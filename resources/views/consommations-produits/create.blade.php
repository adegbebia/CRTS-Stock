<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consommations – Création</title>
</head>

<body>

    <h2>Nouvelle fiche de consommation</h2>

    <form action="{{ route('consommations.store') }}" method="POST">
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
        <a href="{{ route('produits.create') }}" target="_blank">Ajouter un produit</a>
        <p><em>Créez le produit puis actualisez cette page.</em></p>

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
                            {{-- Affiche la consommation automatiquement calculée --}}
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
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>


        <button type="submit">Enregistrer</button>
    </form>

    <hr>

    <h3>Consommations enregistrées</h3>
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
                    <th>Action</th>
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
                            <a href="{{ route('consommations.edit', $c->consommation_id) }}">Modifier</a> |
                            <form action="{{ route('consommations.destroy', $c->consommation_id) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune consommation enregistrée.</p>
    @endif

</body>

</html>
