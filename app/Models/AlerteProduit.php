<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AlerteProduit extends Model
{
    //
    protected $table = 'alerte_produits'; // important si le nom est non standard

    protected $primaryKey='alerteProd_id';

    
    
    protected $with = ['produit'];

    


    protected $fillable=[
        'produit_id',
        'typealerte',
        'datedeclenchement',
        
    ];

    protected $casts = [
        'datedeclenchement' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'alerteProd_id';
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id','produit_id');
    }
}
