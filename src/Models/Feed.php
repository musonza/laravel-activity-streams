<?php

namespace Musonza\ActivityStreams\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public function activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'feed_activities',
            'feed_id',
            'activity_id'
        );
    }
}