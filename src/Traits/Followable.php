<?php

namespace Musonza\ActivityStreams\Traits;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Models\Follow;

trait Followable
{
    public function follow(Model $followable)
    {
        $follow = new Follow([
            'follower_id' => $this->getKey(),
            'follower_type' => get_class($followable),
        ]);

        return $followable->follows()->save($follow);
    }

    public function unfollow(Model $followable)
    {
        $followable->follows()
            ->where('follower_id', $this->getKey())
            ->where('follower_type', get_class($followable))
            ->delete();
    }

    public function isFollowed(Model $followable)
    {
        return !!$this->follows()
            ->where('follower_id', $followable->getKey())
            ->where('follower_type', get_class($followable))
            ->count();
    }

    public function getFollowersCountAttribute()
    {
        return $this->follows()->count();
    }

    public function follows()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function followers()
    {
        return $this->morphTo();
    }
}
