<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Générer un rapport</title>
</head>
<body>
    <h2>Génération de rapport</h2>

    <form method="POST" action="{{ route('rapports-produits.generer') }}">
         @csrf
        <label>Type de rapport :</label><br>
        <input type="radio" name="type" value="mois" required> Mensuel<br>
        <input type="radio" name="type" value="trimestre"> Trimestriel<br>
        <input type="radio" name="type" value="semestre"> Semestriel<br><br>

        <label>Choisir le mois :</label><br>
        <select name="mois">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select><br><br>

        <label>Trimestre :</label><br>
        <select name="trimestre">
            <option value="1">1 (Janv-Mars)</option>
            <option value="2">2 (Avr-Juin)</option>
            <option value="3">3 (Juil-Sept)</option>
            <option value="4">4 (Oct-Déc)</option>
        </select><br><br>

        <label>Semestre :</label><br>
        <select name="semestre">
            <option value="1">1 (Janv-Juin)</option>
            <option value="2">2 (Juil-Déc)</option>
        </select><br><br>

        <label>Année :</label><br>
        <input type="number" name="annee" value="{{ date('Y') }}" required><br><br>

        <input type="submit" value="Générer le rapport">
    </form>

    @if(session('pdf'))
        <p><a href="{{ session('pdf') }}">📄 Télécharger le rapport généré</a></p>
    @endif
</body>
</html>
