<?php

namespace Musonza\ActivityStreams\ValueObjects;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Contracts\ActivityObject as ActivityObjectInterface;
use Musonza\ActivityStreams\Contracts\ReturnsExtraData;

class ActivityObject implements ActivityObjectInterface
{
    /**
     * @var string
     */
    protected $objectType;

    /**
     * @var string
     */
    protected $objectIdentifier;

    /**
     * @var array
     */
    protected $extraData;

    /**
     * ActivityObject constructor.
     * @param string $objectType
     * @param string $objectIdentifier
     * @param array $extraData
     */
    public function __construct(string $objectType, string $objectIdentifier, array $extraData = [])
    {
        $this->objectType = $objectType;
        $this->objectIdentifier = $objectIdentifier;
        $this->extraData = $extraData;
    }

    public static function createFromModel(Model $model, $extraData = []): ActivityObject
    {
        if ($model instanceof ReturnsExtraData) {
            $extraData = $model->getExtraData();
        }

        return new static(get_class($model), $model->getKey(), $extraData);
    }

    public function getType(): string
    {
        return $this->objectType;
    }

    public function getIdentifier(): string
    {
        return $this->objectIdentifier;
    }

    public function getExtraData(): array
    {
        return $this->extraData;
    }
}