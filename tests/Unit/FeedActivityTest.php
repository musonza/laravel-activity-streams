<?php

namespace Musonza\ActivityStreams\Tests\Unit;

use Exception;
use Musonza\ActivityStreams\Managers\ActivityManager;
use Musonza\ActivityStreams\Models\Activity;
use Musonza\ActivityStreams\Models\Feed;
use Musonza\ActivityStreams\Tests\Helpers\Models\User;
use Musonza\ActivityStreams\Tests\TestCase;
use Musonza\ActivityStreams\ValueObjects\Actor;

class FeedActivityTest extends TestCase
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Feed
     */
    private $feed;
    /**
     * @var ActivityManager
     */
    private $activityService;

    /**
     * @throws Exception
     */
    public function testAddFeedActivityWithModelActor()
    {
        $this->createFeed();

        /** @var Activity $activity */
        $activity = $this->activityService->model($this->user)
            ->setVerb('post')
            ->setTarget(4)
            ->setObject(5)
            ->createActivity();

        $this->assertDatabaseHas(TestCase::ACTIVITIES_TABLE, [
            'id' => 1,
            'actor_type' => get_class($this->user),
            'actor_id' => $this->user->id,
        ]);

        $this->activityService->addActivityToFeed($this->feed, $activity);

        $this->assertSame(1, $this->feed->activities()->count());
    }

    protected function createFeed()
    {
        $this->user = factory(User::class)->create();
        $this->feed = $this->user->createFeed();
        $this->activityService = app(ActivityManager::class);
    }

    /**
     * @throws Exception
     */
    public function testAddFeedActivityWithNoneModelActor()
    {
        $this->createFeed();

        $actor = new Actor('twitter_user', 126626);

        /** @var Activity $activity */
        $activity = $this->activityService->setActor($actor)
            ->setVerb('post')
            ->setTarget(4)
            ->setObject(5)
            ->createActivity();

        $this->assertDatabaseHas(TestCase::ACTIVITIES_TABLE, [
            'id' => 1,
            'actor_type' => 'twitter_user',
            'actor_id' => '126626',
        ]);

        $this->activityService->addActivityToFeed($this->feed, $activity);

        $this->assertSame(1, $this->feed->activities()->count());
    }
}