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

    /**
     * Bootstrap application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishMigrations();
        $this->publishConfig();
    }

    public function register()
    {
        $this->app->bind('activity_streams', function () {
            return $this->app->make(ActivityStreams::class);
        });
    }

    /**
     * Publish package's migrations.
     *
     * @return void
     */
    public function publishMigrations()
    {
        $timestamp = date('Y_m_d_His', time());
        $stub = __DIR__.'/../database/migrations/create_activity_streams_tables.php';
        $target = $this->app->databasePath() . '/migrations/' . $timestamp . '_create_activity_streams_tables.php';
        $this->publishes([$stub => $target], 'activity.streams.migrations');
    }

    /**
     * Publish package's config file.
     *
     * @return void
     */
    public function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config' => config_path(),
        ], 'activity.streams.config');
    }
}