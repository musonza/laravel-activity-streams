<?php

namespace Musonza\ActivityStreams\Managers;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Contracts\ActivityActor;
use Musonza\ActivityStreams\Contracts\ActivityTarget;
use Musonza\ActivityStreams\Exceptions\InvalidActivityVerbException;
use Musonza\ActivityStreams\Models\Activity;
use Musonza\ActivityStreams\Models\Feed;
use Musonza\ActivityStreams\ValueObjects\Actor;

/*
  {
    "published": "2011-02-10T15:04:55Z",
    "actor": {
      "url": "http://example.org/martin",
      "objectType" : "person",
      "id": "tag:example.org,2011:martin",
      "image": {
        "url": "http://example.org/martin/image",
        "width": 250,
        "height": 250
      },
      "displayName": "Martin Smith"
    },
    "verb": "post",
    "object" : {
      "url": "http://example.org/blog/2011/02/entry",
      "id": "tag:example.org,2011:abc123/xyz"
    },
    "target" : {
      "url": "http://example.org/blog/",
      "objectType": "blog",
      "id": "tag:example.org,2011:abc123",
      "displayName": "Martin's Blog"
    }
  }
 */

class ActivityManager
{
    /**
     * @var Activity
     */
    protected $activity;
    /**
     * @var string
     */
    protected $verb;
    /**
     * @var ActivityTarget
     */
    protected $target;

    /**
     * @var ActivityActor
     */
    protected $actor;
    private $activityObject;
    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * ActivityManager constructor.
     * @param Activity $activity
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(Activity $activity, ConfigurationManager $configurationManager)
    {
        $this->activity = $activity;
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param Model $model
     * @return ActivityManager
     */
    public function model(Model $model)
    {
        return $this->setActor(Actor::createActorFromModel($model));
    }

    /**
     * @param ActivityActor $actor
     * @return $this
     */
    public function setActor(ActivityActor $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * @param string $verb
     * @return ActivityManager
     * @throws InvalidActivityVerbException
     */
    public function setVerb(string $verb): self
    {
        $this->configurationManager->validateVerb($verb);

        $this->verb = $verb;

        return $this;
    }

    public function setTarget(ActivityTarget $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function setObject($activityObject): self
    {
        $this->activityObject = $activityObject;

        return $this;
    }

    public function createActivity(): Activity
    {
        $activityData = [
            'actor_type' => $this->actor->getType(),
            'actor_id' => $this->actor->getIdentifier(),
            'verb' => $this->verb,
            'object' => $this->activityObject,
            'target_type' => $this->target->getType(),
            'target_id' => $this->target->getIdentifier(),
        ];

        $activity =  $this->activity->newInstance($activityData);

        $activity->save();

        return $activity;
    }

    public function addActivityToFeed(Feed $feed, Activity $activity): void
    {
        $feed->activities()->attach($activity);
    }
}