<?php

namespace Musonza\ActivityStreams\Models;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Events\ActivityCreated;
use Musonza\ActivityStreams\Events\ActivityDeleted;

class Activity extends Model
{
    protected $fillable = [
        'actor_type',
        'actor_id',
        'actor_data',
        'verb',
        'target_type',
        'target_id',
        'target_data',
        'object_type',
        'object_id',
        'object_data',
    ];
    protected $casts = [
        'actor_data' => 'array',
        'target_data' => 'array',
        'object_data' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($activity) {
            event(new ActivityCreated($activity));
        });

        static::deleted(function ($activity) {
            event(new ActivityDeleted($activity));
        });
    }

    public function feeds()
    {
        return $this->hasMany(FeedActivity::class);
    }
}