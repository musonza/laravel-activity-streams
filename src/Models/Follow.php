<?php

namespace Musonza\ActivityStreams\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'follower_id',
        'follower_type',
    ];

    public function feeds()
    {
        return $this->morphedByMany(Feed::class, 'followable');
    }
}