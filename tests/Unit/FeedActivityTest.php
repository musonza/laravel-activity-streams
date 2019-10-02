<?php

namespace Musonza\ActivityStreams\Tests\Unit;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Managers\ActivityManager;
use Musonza\ActivityStreams\Models\Activity;
use Musonza\ActivityStreams\Models\Feed;
use Musonza\ActivityStreams\Tests\Helpers\Models\Blog;
use Musonza\ActivityStreams\Tests\Helpers\Models\User;
use Musonza\ActivityStreams\Tests\Helpers\Targets\SampleTarget;
use Musonza\ActivityStreams\Tests\TestCase;
use Musonza\ActivityStreams\ValueObjects\Actor;
use Musonza\ActivityStreams\ValueObjects\Verbs;

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

    protected function isActorModel($actor)
    {
        return $actor instanceof Model;
    }

    /**
     * @throws Exception
     * @dataProvider activitiesDataProvider
     */
    public function testAddFeedActivityWithModelActor($target, $actor)
    {
        $this->createFeed();

        if (isset($actor['is_model'])) {
            $actor['value'] = $this->user;
            $this->activityService = $this->activityService->actorModel($actor['value']);
        } else {
            $this->activityService = $this->activityService->setActor($actor['value']);
        }

        /** @var Activity $activity */
        $activity = $this->activityService
            ->setVerb(Verbs::POST)
            ->setTarget($target)
            ->setObject(5)
            ->createActivity();

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
     * @dataProvider activitiesDataProvider
     */
    public function testAddFeedActivityWithNoneModelActor($target, $actor)
    {
        $this->createFeed();

        if (isset($actor['is_model'])) {
            $actor['value'] = $this->user;
            $this->activityService = $this->activityService->actorModel($actor['value']);
        } else {
            $this->activityService = $this->activityService->setActor($actor['value']);
        }

        /** @var Activity $activity */
        $activity = $this->activityService
            ->setVerb('post')
            ->setTarget($target)
            ->setObject(5)
            ->createActivity();

        $this->activityService->addActivityToFeed($this->feed, $activity);

        $this->assertSame(1, $this->feed->activities()->count());
    }

    public function activitiesDataProvider()
    {
        return [
            [
                'target' => new SampleTarget(),
                'actor' => [
                    'is_model' => true,
                    'value' => null,
                ],
            ],
            [
                'target' => new SampleTarget(),
                'actor' => [
                    'value' => new Actor('twitter_user', 126626)
                ],
            ],
        ];
    }
}