<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AlerteArticle extends Model
{
    //
    protected $primaryKey='alerteArt_id';

    protected $fillable=[
        'article_id',
        'typealerte',
        'datedeclenchement',
        
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'article_id');
    }
}
