<?php

namespace Musonza\ActivityStreams\Tests\Unit;

use Musonza\ActivityStreams\Models\Activity;
use Musonza\ActivityStreams\Tests\Helpers\Models\User;
use Musonza\ActivityStreams\Tests\TestCase;
use Musonza\ActivityStreams\ActivityStreams;
use Musonza\ActivityStreams\ValueObjects\Verbs;
use Musonza\ActivityStreams\Tests\Helpers\Targets\SampleTarget;

class FacadeTest extends TestCase
{
    /**
     * @var ActivityStreams
     */
    private $activityStreams;

    public function setUp(): void
    {
        parent::setUp();
        $this->activityStreams = app(ActivityStreams::class);
    }

    public function testGetDefinedVerbs()
    {
        $verbs = $this->activityStreams->verbs();

        $this->assertIsArray($verbs);
        $this->assertEquals('post', $verbs['VERB_POST']);
    }

    public function testCreateActivity()
    {
        $actor = factory(User::class)->create();

        $activity = $this->activityStreams->setActor($actor)
            ->setVerb(Verbs::VERB_POST)
            ->setObject(1)
            ->setTarget(new SampleTarget())
            ->createActivity();

        $this->assertInstanceOf(Activity::class, $activity);
    }

    public function testAddActivityToFeed()
    {
        $user = factory(User::class)->create();
        $feed = $user->createFeed();

        $activity = $this->activityStreams->setActor($user)
            ->setVerb(Verbs::VERB_POST)
            ->setObject(1)
            ->setTarget(new SampleTarget())
            ->createActivity();

        $this->activityStreams->addActivityToFeed($feed, $activity);

        $this->assertEquals(1, $feed->activities()->count());
    }
}