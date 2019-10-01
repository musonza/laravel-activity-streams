<?php

namespace Musonza\ActivityStreams\Models;

use Illuminate\Database\Eloquent\Model;

class FeedActivity extends Model
{
    protected $fillable = [
        'feed_id',
        'activity_id',
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class, 'feed_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}