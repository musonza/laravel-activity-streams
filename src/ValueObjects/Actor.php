<?php


namespace Musonza\ActivityStreams\ValueObjects;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Contracts\ActivityActor;

class Actor implements ActivityActor
{
    /**
     * @var string
     */
    protected $actorType;
    /**
     * @var string
     */
    protected $actorIdentifier;
    /**
     * @var array
     */
    protected $extraData;

    public function __construct(string $actorType, string $actorIdentifier, array $extraData = [])
    {
        $this->actorType = $actorType;
        $this->actorIdentifier = $actorIdentifier;
        $this->extraData = $extraData;
    }

    public static function createActorFromModel(Model $model, $extraData = []): Actor
    {
        return new static(get_class($model), $model->getKey(), $extraData);
    }

    public function getType(): string
    {
        return $this->actorType;
    }

    public function getIdentifier(): string
    {
        return $this->actorIdentifier;
    }

    /**
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
    }
     *
     * @return array
     */
    public function getDetails(): array
    {
        /**
         * avatar
         * name
         * url - function to generate url as well
         */
        // TODO
        return [];
    }
}