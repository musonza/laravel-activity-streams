<?php

namespace Musonza\ActivityStreams\Events;

use Musonza\ActivityStreams\Models\Activity;

class ActivityCreated extends Event
{
    /**
     * @var Activity
     */
    public $activity;

    public function __construct(Activity $activity)
    {
        $this->activity  = $activity;
    }
}