<?php

namespace Musonza\ActivityStreams;

use Illuminate\Support\Facades\Facade;

class ActivityStreamsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'activity_streams';
    }
}