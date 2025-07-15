<?php

namespace App\Observers;

use App\Models\Produit;
use App\Models\Alerte;
use Carbon\Carbon;

class ProduitObserver
{
    /**
     * Handle the Produit "created" event.
     */
    public function created(Produit $produit): void
    {
        // Optionnel : déclencher alertes lors de la création si nécessaire
    }

    /**
     * Handle the Produit "updated" event.
     */
    public function updated(Produit $produit): void
    {
        // Vérifier si la quantité ou la date de péremption a changé
        if ($produit->wasChanged('quantitestock') || $produit->wasChanged('dateperemption')) {
            $stock = $produit->quantitestock;
            $stockSecu = $produit->stocksecurite;
            $stockMin = $produit->stockmin;
            $stockMax = $produit->stockmax;
            $datePeremption = Carbon::parse($produit->dateperemption);
            $now = Carbon::now();

            // Supprimer les alertes existantes de ce produit
            Alerte::where('produit_id', $produit->produit_id)->delete();

            // Alerte produit périmé (date de péremption avant aujourd'hui)
            if ($datePeremption->lt($now)) {
                Alerte::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Produit périmé',
                ]);
            }

            // Alertes selon le stock (en respectant l'ordre et logique)
            if ($stock <= 0) {
                Alerte::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Rupture de stock',
                ]);
            } elseif ($stock <= $stockSecu) {
                Alerte::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Alerte rouge',
                ]);
            } elseif ($stock <= $stockMin) {
                Alerte::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Alerte orange',
                ]);
            } elseif ($stock > $stockMin && $stock <= $stockMax) {
                Alerte::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Alerte verte',
                ]);
            } else {
                // Stock supérieur au stockmax => pas d'alerte
            }
        }
    }

    /**
     * Handle the Produit "deleted" event.
     */
    public function deleted(Produit $produit): void
    {
        // Supprimer les alertes liées au produit supprimé
        Alerte::where('produit_id', $produit->produit_id)->delete();
    }

    /**
     * Handle the Produit "restored" event.
     */
    public function restored(Produit $produit): void
    {
        // Recalculer les alertes lors de la restauration si nécessaire
        $this->updated($produit);
    }

    /**
     * Handle the Produit "force deleted" event.
     */
    public function forceDeleted(Produit $produit): void
    {
        // Même action que deleted
        $this->deleted($produit);
    }
}
