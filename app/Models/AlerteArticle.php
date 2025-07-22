<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AlerteArticle extends Model
{
    //
    protected $primaryKey='alerteProd_id';

    protected $fillable=[
        'produit_id',
        'typealerte',
        'datedeclenchement',
        
    ];

    public function article()
    {
        return $this->belongsTo(Produit::class, 'article_id', 'article_id');
    }
}
