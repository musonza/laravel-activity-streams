<?php

namespace Musonza\ActivityStreams\Tests\Unit;

use Musonza\ActivityStreams\Tests\Helpers\Models\User;
use Musonza\ActivityStreams\Tests\TestCase;

class FeedTest extends TestCase
{
    public function testCreateModelFeed()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $user->createFeed();

        $this->assertDatabaseHas(TestCase::FEEDS_TABLE, [
           'id' => 1,
            'feedable_type' => get_class($user),
            'feedable_id' => $user->id,
        ]);
    }
}