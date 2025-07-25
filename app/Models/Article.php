<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MouvementArticle;
use App\Models\ConsommationArticle;
use App\Models\AlerteArticle;
use Carbon\Carbon;

class Article extends Model
{
    protected $primaryKey = 'article_id';

    protected $fillable = [
        'codearticle',
        'libelle',
        'conditionnement',
        'quantitestock',
        'stockmax',
        'stockmin',
        'stocksecurite',
        'dateperemption',
        'lot',
        'date',
        'user_id',
    ];

    /* Relations */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(MouvementArticle::class, 'article_id'); 
    }

    public function consommations(): HasMany
    {
        return $this->hasMany(ConsommationArticle::class, 'article_id'); 
    }

    public function alertes(): HasMany
    {
        return $this->hasMany(AlerteArticle::class, 'article_id'); 
    }

    
}

