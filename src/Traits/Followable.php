<?php

namespace Musonza\ActivityStreams\Traits;

use Musonza\ActivityStreams\Models\Feed;
use Musonza\ActivityStreams\Models\Follow;

trait Followable
{
    public function follow(Feed $followable)
    {
        $follow = new Follow(['follower_id' => $this->getKey()]);

        return $followable->follows()->save($follow);
    }

    public function unfollow(Feed $followable)
    {
        $followable->follows()->where('follower_id', $this->getKey())->delete();
    }

    public function isFollowed(Feed $followable)
    {
        return !!$this->follows()
            ->where('follower_id', $followable->getKey())
            ->count();
    }

    public function getFollowersCountAttribute()
    {
        return $this->follows()->count();
    }

    /**
     * Fetch records that are followed by a given user.
     * Ex: Feed::whereFollowedBy(123)->get();
     */
    public function scopeWhereFollowedBy($query, $followerId)
    {
        return $query->whereHas('follows', function ($q) use ($followerId) {
            $q->where('follower_id', $followerId);
        });
    }

    public function scopeWhereFollowers($query, $followerId)
    {
        return $query->whereHas('follows', function ($q) use ($followerId) {
            $q->where('follower_id', $followerId);
        });
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
