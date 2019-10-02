<?php

namespace Musonza\ActivityStreams;

use Illuminate\Support\ServiceProvider;

class ActivityStreamsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function register()
    {
        $this->app->bind('activity_streams', function () {
            return $this->app->make(ActivityStreams::class);
        });
    }

}