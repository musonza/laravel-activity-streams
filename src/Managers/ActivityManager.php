<?php

namespace Musonza\ActivityStreams\Managers;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Contracts\ActivityActor;
use Musonza\ActivityStreams\Contracts\ActivityObject;
use Musonza\ActivityStreams\Contracts\ActivityTarget;
use Musonza\ActivityStreams\Exceptions\InvalidActivityVerbException;
use Musonza\ActivityStreams\Models\Activity;
use Musonza\ActivityStreams\Models\Feed;
use Musonza\ActivityStreams\ValueObjects\Target;

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

    /**
     * @var ActivityObject
     */
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

    public function targetModel(Model $model)
    {
        return $this->setTarget(Target::createFromModel($model));
    }

    public function setTarget(ActivityTarget $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function setObject(ActivityObject $activityObject): self
    {
        $this->activityObject = $activityObject;

        return $this;
    }

    public function createActivity(): Activity
    {
        $activityData = [
            'actor_type' => $this->actor->getType(),
            'actor_id' => $this->actor->getIdentifier(),
            'actor_data' => $this->actor->getExtraData(),
            'verb' => $this->verb,
            'object_type' => $this->activityObject->getType(),
            'object_id' => $this->activityObject->getIdentifier(),
            'object_data' => $this->activityObject->getExtraData(),
            'target_type' => $this->target->getType(),
            'target_id' => $this->target->getIdentifier(),
            'target_data' => $this->target->getExtraData(),
        ];

        $activity = $this->activity->newInstance($activityData);

        $activity->save();

        return $activity;
    }

    public function addActivityToFeed(Feed $feed, Activity $activity): void
    {
        $feed->activities()->attach($activity);
    }
}