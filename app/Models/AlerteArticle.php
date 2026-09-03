<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AlerteArticle extends Model
{
    //
    protected $table = 'alerte_articles'; // important si le nom est non standard


    protected $primaryKey='alerteArt_id';

    protected $with = ['article'];

    protected $fillable=[
        'article_id',
        'typealerte',
        'datedeclenchement',
        
    ];

    protected $casts = [
        'datedeclenchement' => 'datetime',
    ];


    public function getRouteKeyName()
    {
        return 'alerteArt_id';
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'article_id');
    }
}
