<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MouvementArticle extends Model
{
    //

    protected $primaryKey ='mouvementArt_id';

    protected $fillable = [

        'article_id',
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

    public function article():BelongsTo{

        return $this->belongsTo(Article::class,'article_id');
    } 
}
