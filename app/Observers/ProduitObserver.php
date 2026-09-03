<?php

namespace App\Observers;

use App\Models\Produit;
use App\Models\AlerteProduit;
use Carbon\Carbon;

class ProduitObserver
{
    /**
     * Handle the Produit "created" event.
     */
    public function created(Produit $produit): void
    {
        
    }

    /**
     * Handle the Produit "updated" event.
     */
    public function updated(Produit $produit): void
    {
        // Vérifier si la quantité ou la date de péremption a changé
        if ($produit->wasChanged('quantitestock') || $produit->wasChanged('dateperemption')) {
            $stock      = $produit->quantitestock;
            $stockSecu  = $produit->stocksecurite;
            $stockMin   = $produit->stockmin;
            $stockMax   = $produit->stockmax;

            // Supprimer les alertes existantes de ce produit
            AlerteProduit::where('produit_id', $produit->produit_id)->delete();

            // Alerte produit périmé (si une date existe ET est passée)
            if (!empty($produit->dateperemption)) {
                $datePeremption = Carbon::parse($produit->dateperemption);
                if ($datePeremption->lt(now())) {
                    AlerteProduit::create([
                        'produit_id' => $produit->produit_id,
                        'typealerte' => 'Produit périmé',
                    ]);
                }
            }

            // Alertes selon le stock (en respectant l'ordre et logique)
            if ($stock <= 0) {
                AlerteProduit::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Rupture de stock',
                ]);
            } elseif ($stock <= $stockSecu) {
                AlerteProduit::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Alerte rouge',
                ]);
            } elseif ($stock <= $stockMin) {
                AlerteProduit::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Alerte orange',
                ]);
            } elseif ($stock > $stockMin && $stock <= $stockMax) {
                AlerteProduit::create([
                    'produit_id' => $produit->produit_id,
                    'typealerte' => 'Alerte verte',
                ]);
            }
           
        }
    }

    /**
     * Handle the Produit "deleted" event.
     */
    public function deleted(Produit $produit): void
    {
        
        AlerteProduit::where('produit_id', $produit->produit_id)->delete();
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
