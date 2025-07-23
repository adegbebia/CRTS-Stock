<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MouvementProduit;
use App\Models\ConsommationProduit;
use App\Models\AlerteProduit;
use Carbon\Carbon;

class Produit extends Model
{
    protected $primaryKey = 'produit_id';

    protected $fillable = [
        'codeproduit',
        'libelle',
        'conditionnement',
        'quantitestock',
        'stockmax',
        'stockmin',
        'stocksecurite',
        'dateperemption',
        'lot',
        'user_id',
    ];

    /* Relations */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class, 'produit_id'); 
    }

    public function consommations(): HasMany
    {
        return $this->hasMany(Consommation::class, 'produit_id'); 
    }

    public function alertes(): HasMany
    {
        return $this->hasMany(Alerte::class, 'produit_id'); 
    }


    
}
