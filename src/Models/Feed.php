<?php

namespace Musonza\ActivityStreams\Models;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Events\FeedCreated;
use Musonza\ActivityStreams\Events\FeedDeleted;
use Musonza\ActivityStreams\Traits\Followable;

class Feed extends Model
{
    use Followable;

    protected $fillable = [
        'extra',
        'feedable_type',
        'feedable_id'
    ];
    protected $casts = [
        'extra' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function($feed) {
            event(new FeedCreated($feed));
        });

        static::deleted(function($feed) {
            event(new FeedDeleted($feed));
        });
    }

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