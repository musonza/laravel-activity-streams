<?php

namespace Musonza\ActivityStreams\ValueObjects;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Contracts\ActivityTarget;
use Musonza\ActivityStreams\Contracts\ReturnsExtraData;

class Target implements ActivityTarget
{
    /**
     * @var string
     */
    private $targetType;

    /**
     * @var string
     */
    private $targetIdentifier;

    /**
     * @var array
     */
    private $extraData;

    public function __construct(string $targetType, string $targetIdentifier, array $extraData = [])
    {
        $this->targetType = $targetType;
        $this->targetIdentifier = $targetIdentifier;
        $this->extraData = $extraData;
    }

    public static function createFromModel(Model $model, $extraData = []): Target
    {
        if ($model instanceof ReturnsExtraData) {
            $extraData = $model->getExtraData();
        }

        return new static(get_class($model), $model->getKey(), $extraData);
    }

    public function getType(): string
    {
        return $this->targetType;
    }

    public function getIdentifier(): string
    {
        return $this->targetIdentifier;
    }

    public function getExtraData(): array
    {
        return $this->extraData;
    }
}