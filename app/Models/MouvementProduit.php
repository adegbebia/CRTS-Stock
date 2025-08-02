<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MouvementProduit extends Model
{
    //

    protected $primaryKey ='mouvementProd_id';

    protected $fillable = [

        'produit_id',
        // 'user_id',
        'date',
        'origine',
        'quantite_commandee',
        'quantite_entree',
        'quantite_sortie',
        'stock_debut_mois',
        'avarie',
        'stock_jour',
        'observation',
    ];

    public function user():BelongsTo{

        return $this->belongsTo(User::class,'user_id','user_id');
     }

  

    public function produit()
        {
            return $this->belongsTo(Produit::class, 'produit_id');
        }

}
