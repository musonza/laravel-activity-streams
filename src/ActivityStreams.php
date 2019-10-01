<?php

namespace Musonza\ActivityStreams;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Managers\ActivityManager;
use Musonza\ActivityStreams\Managers\ConfigurationManager;
use Musonza\ActivityStreams\Models\Activity;
use Musonza\ActivityStreams\Models\Feed;

class ActivityStreams
{
    /**
     * @var ActivityManager
     */
    public $activityManager;

    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * ActivityStreams constructor.
     * @param ActivityManager $activityManager
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(ActivityManager $activityManager, ConfigurationManager $configurationManager)
    {
        $this->activityManager = $activityManager;
        $this->configurationManager = $configurationManager;
    }

    /**
     * Add an activity to a feed.
     * 
     * @param Feed $feed
     * @param Activity $activity
     */
    public function addActivityToFeed(Feed $feed, Activity $activity): void
    {
        $this->activityManager->addActivityToFeed($feed, $activity);
    }

    /**
     * Sets activity actor.
     *
     * @param $actor
     * @return ActivityStreams
     */
    public function setActor($actor): self
    {
        if ($actor instanceof Model) {
            $this->activityManager->actorModel($actor);
        } else {
            $this->activityManager->setActor($actor);
        }

        return $this;
    }

    /**
     * Set activity target.
     *
     * @param $target
     * @return ActivityStreams
     */
    public function setTarget($target): self
    {
        $this->activityManager->setTarget($target);

        return $this;
    }

    /**
     * Sets activity object.
     *
     * @param $activityObject
     * @return ActivityStreams
     */
    public function setObject($activityObject): self
    {
        $this->activityManager->setObject($activityObject);
        return $this;
    }

    /**
     * Gets supported verbs.
     *
     * @return array
     */
    public function verbs(): array
    {
        return $this->configurationManager->getVerbs();
    }

    /**
     * Persist the activity.
     *
     * @return Activity
     */
    protected function saveActivity(): Activity
    {
        return $this->activityManager->createActivity();
    }
}