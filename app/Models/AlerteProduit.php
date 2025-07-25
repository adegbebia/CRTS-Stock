<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AlerteProduit extends Model
{
    //
    protected $primaryKey='alerteProd_id';

    protected $fillable=[
        'produit_id',
        'typealerte',
        'datedeclenchement',
        
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'produit_id');
    }
}
