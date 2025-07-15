<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produit;
use App\Models\Alerte;
use Carbon\Carbon;

class CheckProductAlerts extends Command
{
    protected $signature = 'alerts:check';
    protected $description = 'Vérifie les produits et génère les alertes automatiques';

    public function handle()
    {
        $now = Carbon::now();
        $produits = Produit::all();

        foreach ($produits as $produit) {
            $alerteType = null;

            // Date de péremption dépassée
            if ($produit->dateperemption && $produit->dateperemption->isPast()) {
                $alerteType = 'perime';
            }
            // Rupture de stock
            elseif ($produit->quantitestock <= 0) {
                $alerteType = 'rupture';
            }
            // Alerte rouge : stock <= stock de sécurité
            elseif ($produit->quantitestock <= $produit->stocksecurite) {
                $alerteType = 'rouge';
            }
            // Alerte orange : stock <= stock min
            elseif ($produit->quantitestock <= $produit->stockmin) {
                $alerteType = 'orange';
            }
            // Alerte jaune : stock >= stock min
            elseif ($produit->quantitestock >= $produit->stockmin) {
                $alerteType = 'jaune';
            }
            // Alerte verte : stock min < stock <= stock max
            if ($produit->quantitestock > $produit->stockmin && $produit->quantitestock <= $produit->stockmax) {
                $alerteType = 'verte';
            }

            if ($alerteType) {
                // On évite les doublons d'alertes du même type pour le même produit
                $exists = Alerte::where('produit_id', $produit->produit_id)
                    ->where('typealerte', $alerteType)
                    ->exists();

                if (!$exists) {
                    Alerte::create([
                        'produit_id' => $produit->produit_id,
                        'typealerte' => $alerteType,
                        'datedeclenchement' => $now,
                    ]);
                    $this->info("Alerte $alerteType créée pour le produit {$produit->libelle}");
                }
            }
        }

        return 0;
    }
}
