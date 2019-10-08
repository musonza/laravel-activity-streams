<?php

namespace Musonza\ActivityStreams\Tests;

require __DIR__.'/../database/migrations/create_activity_streams_tables.php';
require __DIR__.'/Helpers/migrations.php';

use CreateTestTables;
use CreateActivityStreamsTables;
use Illuminate\Foundation\Application;
use Musonza\ActivityStreams\ActivityStreamsFacade;
use Musonza\ActivityStreams\ActivityStreamsServiceProvider;
use Orchestra\Database\ConsoleServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    const FEEDS_TABLE = 'feeds';
    const ACTIVITIES_TABLE = 'activities';

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench']);
        $this->withFactories(__DIR__ . '/Helpers/factories');

        (new CreateActivityStreamsTables())->up();
        (new CreateTestTables())->up();
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('activity_streams', include(__DIR__ . '/../config/activity_streams.php'));
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            ActivityStreamsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ActivityStreams' => ActivityStreamsFacade::class,
        ];
    }

    public function tearDown(): void
    {
        (new CreateActivityStreamsTables())->down();
        (new CreateTestTables())->down();
        parent::tearDown();
    }
}