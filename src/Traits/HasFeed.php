<?php

namespace Musonza\ActivityStreams\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Musonza\ActivityStreams\Models\Feed;

trait HasFeed
{
    /**
     * Get all of the owning has models.
     *
     * @return MorphTo
     */
    public function feedable(): MorphTo
    {
        return $this->morphTo();
    }

    public function feed(): MorphOne
    {
        return $this->morphOne(Feed::class, 'feedable');
    }

    /**
     * Create a feed.
     *
     * @param array $data
     * @return false|Model
     */
    public function createFeed(array $data = [])
    {
        return $this->feed()->save(new Feed($data));
    }
}
