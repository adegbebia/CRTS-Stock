<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Carbon\Carbon;
use App\Models\Produit;
use App\Models\MouvementProduit;
use Illuminate\Http\Request;

class RapportArticleController extends Controller
{
   public function genererRapportLatex($periodeType, $periode, $annee)
{
    // Calcul des mois à inclure selon le type de période
    if ($periodeType === 'mois') {
        $moisDebut = $periode;
        $moisFin = $periode;
    } elseif ($periodeType === 'trimestre') {
        $moisDebut = ($periode - 1) * 3 + 1;
        $moisFin = $moisDebut + 2;
    } elseif ($periodeType === 'semestre') {
        $moisDebut = ($periode - 1) * 6 + 1;
        $moisFin = $moisDebut + 5;
    } else {
        return response("Type de période invalide", 400);
    }

    // Nom de la période pour le titre
    if ($periodeType === 'mois') {
        $periodeNom = Carbon::createFromDate($annee, $periode, 1)
                             ->locale('fr_FR')
                             ->translatedFormat('F');
    } elseif ($periodeType === 'trimestre') {
        $periodeNom = "T$periode";
    } else {
        $periodeNom = "Semestre $periode";
    }

    // Chargement du template (pense à adapter le template pour {{periode}} au lieu de {{mois}})
    $template = file_get_contents(resource_path('latex/rapport_mensuel_template.tex'));
    if ($template === false) {
        return response("❌ Le template LaTeX est introuvable ou illisible", 500);
    }

    // Récupère tous les produits
    $produits = Produit::all();
    $rows = '';

    foreach ($produits as $produit) {
        $mouvements = Mouvement::where('produit_id', $produit->produit_id)
        ->whereYear('date', $annee)
        ->whereRaw("CAST(strftime('%m', date) AS INTEGER) BETWEEN ? AND ?", [$moisDebut, $moisFin])
        ->get();

    foreach ($articles as $article) {
            $mouvements = MouvementProduit::where('article_id', $article->articleid)
                ->whereYear('date', $annee)
                ->whereRaw("CAST(strftime('%m', date) AS INTEGER) BETWEEN ? AND ?", [$moisDebut, $moisFin])
                ->get();

        if ($mouvements->isEmpty()) {
            continue;
        }

        $stockDebut   = $mouvements->first()->stock_debut_mois ?? 0;
        $entree       = $mouvements->sum('quantite_entree');
        $stockTotal   = $stockDebut + $entree;
        $sortie       = $mouvements->sum('quantite_sortie');
        $stockFin     = $stockTotal - $sortie;
        $unite        = $mouvements->pluck('origine')->unique()->implode(', ');
        $observation  = $mouvements->pluck('observation')->unique()->implode(' / ');

        //$rows .= "{$produit->libelle} & $stockDebut & $entree & $stockTotal & (str_replace(',', "\\\\", $unite)) & $sortie & $stockFin & $observation \\\\ \\hline\n";
        $rows .= sprintf(
    "%-30s & %5d & %5d & %5d & %-25s & %5d & %5d & %-30s \\\\ \\hline\n",
    $this->escapeLatex($produit->libelle),
    $stockDebut,
    $entree,
    $stockTotal,
    $this->escapeLatex(str_replace(',', " ", $unite)),
    $sortie,
    $stockFin,
    $this->escapeLatex($observation)
);
    }
    

    // Remplacement dans le template
    $latexContent = str_replace(
        ['{{periode}}', '{{annee}}', '{{rows}}'],
        [ucfirst($periodeNom), $annee, $rows],
        $template
    );

    if (empty(trim($latexContent))) {
        return response("❌ Le contenu LaTeX est vide. Vérifie le template ou les données.", 500);
    }

    // Enregistrement fichier .tex
    $fileName     = "rapport-{$periodeType}-{$periode}-{$annee}";
    $relativePath = "rapports/{$fileName}.tex";
    $filePath     = storage_path("app/{$relativePath}");

    $bytesWritten = file_put_contents($filePath, $latexContent);

    if ($bytesWritten === false) {
        return response("❌ Échec de l'écriture du fichier .tex via file_put_contents", 500);
    }

    if (!file_exists($filePath)) {
        return response("❌ Le fichier .tex n'a pas été créé physiquement", 500);
    }

    // Chemin vers pdflatex (ajuste selon ta machine)
    $pdflatexPath = '/usr/bin/pdflatex';

    // Compilation PDF
    $process = new Process([
        $pdflatexPath,
        '-interaction=nonstopmode',
        '-output-directory=' . storage_path('app/rapports'),
        $filePath
    ]);
    $process->run();

    if (!$process->isSuccessful()) {
        return response("Erreur pdflatex :\n" . $process->getErrorOutput(), 500);
    }

    $pdfPath = storage_path("app/rapports/{$fileName}.pdf");

    if (!file_exists($pdfPath)) {
        return response("Erreur lors de la génération du PDF", 500);
    }

    return response()->file($pdfPath);
}
}

    /**
     * Échappe les caractères spéciaux LaTeX
     */
    private function escapeLatex(string $text): string
    {
        $escapeMap = [
            '&' => '\&',
            '%' => '\%',
            '$' => '\$',
            '#' => '\#',
            '_' => '\_',
            '{' => '\{',
            '}' => '\}',
            '~' => '\textasciitilde{}',
            '^' => '\textasciicircum{}',
            '\\' => '\textbackslash{}',
        ];
        
        return strtr($text, $escapeMap);
    }

    public function generer(Request $request)
{
    $type = $request->input('type'); // mois, trimestre ou semestre
    $annee = $request->input('annee');

    if (!$type || !$annee) {
        return back()->with('error', 'Merci de renseigner tous les champs requis.');
    }

    // Vérifie et récupère la valeur selon le type
    if ($type === 'mois') {
        $mois = $request->input('mois');
        return $this->genererRapportLatex('mois', $mois, $annee);
    }

    if ($type === 'trimestre') {
        $trimestre = $request->input('trimestre');
        return $this->genererRapportLatex('trimestre', $trimestre, $annee);
    }

    if ($type === 'semestre') {
        $semestre = $request->input('semestre');
        return $this->genererRapportLatex('semestre', $semestre, $annee);
    }

    return back()->with('error', 'Type de rapport invalide.');
}



}
