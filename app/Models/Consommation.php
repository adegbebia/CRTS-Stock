<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Consommation extends Model
{
    //

    protected $primaryKey='consomation_id';

    protected $fillable=[

        'produit_id',
        'annee_consommation',
        'mois',
        'trimestre',
        'semestre',
        'totalAnnuel',
        'nombreJourRuptureStock',
        
    ];


    public function produit():BelongsTo{

        return $this->belongsTo(Produit::class,'produit_id');
    } 
}
