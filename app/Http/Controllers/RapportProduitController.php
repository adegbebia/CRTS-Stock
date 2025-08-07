<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Carbon\Carbon;
use App\Models\Produit;
use App\Models\MouvementProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RapportProduitController extends Controller
{
    public function index()
    {
        return view('rapports-produits.index');
    }

    public function genererRapportLatex($periodeType, $periode, $annee)
    {
        // Définition des bornes de mois selon le type de période
        if ($periodeType === 'mois') {
            $moisDebut = $periode;
            $moisFin = $periode;
            $periodeNom = Carbon::createFromDate($annee, $periode, 1)
                ->locale('fr_FR')->translatedFormat('F');
        } elseif ($periodeType === 'trimestre') {
            $moisDebut = ($periode - 1) * 3 + 1;
            $moisFin = $moisDebut + 2;
            $periodeNom = "T$periode";
        } elseif ($periodeType === 'semestre') {
            $moisDebut = ($periode - 1) * 6 + 1;
            $moisFin = $moisDebut + 5;
            $periodeNom = "Semestre $periode";
        } else {
            return response("Type de période invalide", 400);
        }
        

        $template = file_get_contents(resource_path('latex/rapport_mensuel_template.tex'));
        if ($template === false) {
            return response("❌ Le template LaTeX est introuvable ou illisible", 500);
        }

        $produits = Produit::all();
        $rows = '';

        foreach ($produits as $produit) {
            $mouvements = MouvementProduit::where('produit_id', $produit->produit_id)
                ->whereYear('date', $annee)
                ->whereRaw("CAST(strftime('%m', date) AS INTEGER) BETWEEN ? AND ?", [$moisDebut, $moisFin])
                ->get();

            if ($mouvements->isEmpty()) continue;

            $stockJour = optional($mouvements->first())->stock_jour ?? 0;
            $entree = $mouvements->sum('quantite_entree');
            $stockTotal = $stockJour + $entree;

            $uniteSortieLignes = $mouvements->map(function ($m) {
                return [
                    'origine' => $this->escapeLatex($m->origine ?? 'N/A'),
                    'sortie' => $m->quantite_sortie ?? 0
                ];
            })->values();

            $totalSortie = $uniteSortieLignes->sum('sortie');

            $stockFin = $produit->quantitestock;


            // Modification importante ici :
            // $stockFin = $stockTotal - $totalSortie; // ancienne logique, à retirer
            $stockFin = $produit->quantitestock; // on prend directement le stock final dans la base

            // Mini-tabular Unité
            $uniteColumn = "\\begin{tabular}[t]{@{}l@{}}\n";
            $uniteColumn .= implode(" \\\\\n", $uniteSortieLignes->pluck('origine')->all());
            $uniteColumn .= "\n\\end{tabular}";

            // Mini-tabular Sortie
            $sortieColumn = "\\begin{tabular}[t]{@{}r@{}}\n";
            $sortieColumn .= implode(" \\\\\n", $uniteSortieLignes->pluck('sortie')->map(fn($s) => $this->escapeLatex((string)$s))->all());
            $sortieColumn .= "\n\\end{tabular}";

            // Mini-tabular Observation ligne par ligne (en phase avec les sorties)
                $observations = $mouvements->map(function ($m) {
                    return $this->escapeLatex($m->observation ?? '—');
                })->all();

                $observationColumn = "\\begin{tabular}[t]{@{}l@{}}\n";
                $observationColumn .= implode(" \\\\\n", $observations);
                $observationColumn .= "\n\\end{tabular}";

            $rows .= sprintf(
                "%s & %d & %d & %d & %s & %s & %d & %s \\\\ \\hline\n",
                $this->escapeLatex($produit->libelle),
                $stockJour,
                $entree,
                $stockTotal,
                $uniteColumn,
                $sortieColumn,
                $stockFin,
                $observationColumn
            );


        }


        // Remplacement des variables dans le template
        $latexContent = str_replace(
            ['{{periode}}', '{{annee}}', '{{rows}}'],
            [ucfirst($periodeNom), $annee, $rows],
            $template
        );

        if (empty(trim($latexContent))) {
            return response("❌ Le contenu LaTeX est vide. Vérifie le template ou les données.", 500);
        }

        // Sauvegarde du fichier .tex
        $fileName = "rapport-{$periodeType}-{$periode}-{$annee}-articles";
        $relativePath = "rapports/{$fileName}.tex";
        $filePath = storage_path("app/{$relativePath}");

        $bytesWritten = file_put_contents($filePath, $latexContent);
        if ($bytesWritten === false || !file_exists($filePath)) {
            return response("❌ Échec de l'écriture du fichier .tex", 500);
        }

        // Compilation avec pdflatex
        $pdflatexPath = '/usr/bin/pdflatex'; // adapte selon ton serveur
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

    public function generer(Request $request)
    {
        $type = $request->input('type');
        $annee = $request->input('annee');

        if (!$type || !$annee) {
            return back()->with('error', 'Merci de renseigner tous les champs requis.');
        }

        if ($type === 'mois') {
            return $this->genererRapportLatex('mois', $request->input('mois'), $annee);
        }

        if ($type === 'trimestre') {
            return $this->genererRapportLatex('trimestre', $request->input('trimestre'), $annee);
        }

        if ($type === 'semestre') {
            return $this->genererRapportLatex('semestre', $request->input('semestre'), $annee);
        }

        return back()->with('error', 'Type de rapport invalide.');
    }

    private function escapeLatex(string $text): string
    {
        $escapeMap = [
            '\\' => '\\textbackslash{}',
            '&' => '\\&',
            '%' => '\\%',
            '$' => '\\$',
            '#' => '\\#',
            '_' => '\\_',
            '{' => '\\{',
            '}' => '\\}',
            '~' => '\\textasciitilde{}',
            '^' => '\\textasciicircum{}',
        ];

        return strtr($text, $escapeMap);
    }
}
