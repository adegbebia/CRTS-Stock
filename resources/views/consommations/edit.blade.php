<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier consommation</title>
</head>
<body>

<h2>Modifier la consommation ({{ $consommation->annee }})</h2>

<form action="{{ route('consommations.update', $consommation->consommation_id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Produit :</label>
    <select name="produit_id" required>
        @foreach($produits as $p)
            <option value="{{ $p->produit_id }}" {{ $p->produit_id == $consommation->produit_id ? 'selected' : '' }}>
                {{ $p->libelle }}
            </option>
        @endforeach
    </select>

    <label>Année :</label>
    <input type="number" name="annee" value="{{ $consommation->annee }}" min="2020" max="{{ date('Y') + 1 }}" required>

    <h3>SORTIE MENSUELLES</h3>
    <table border="1" cellpadding="4">
        <thead>
            <tr>
                <th>Mois</th>
                @php
                    $mois = ['janvier','fevrier','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','decembre'];
                @endphp
                @foreach($mois as $m)
                    <th>{{ ucfirst($m) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Consommation</td>
                @foreach($mois as $m)
                    @php $val = $consommation['consommation_'.$m]; @endphp
                    <td>
                        {{ $val }}
                        <input type="hidden" name="consommation_{{ $m }}" value="{{ $val }}">
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>Jours de rupture</td>
                @foreach($mois as $m)
                    <td>
                        <input type="number" name="rupture_{{ $m }}" min="0"
                               value="{{ $consommation['rupture_'.$m] }}" required>
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <button type="submit">Mettre à jour</button>
</form>

<p><a href="{{ route('consommations.create') }}">← Retour à la liste</a></p>

</body>
</html>
