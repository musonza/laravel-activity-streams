<?php

namespace Musonza\ActivityStreams\ValueObjects;

use Musonza\ActivityStreams\Contracts\ActivityTarget;

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

    public function getType(): string
    {
        return $this->targetType;
    }

    public function getIdentifier(): string
    {
        return $this->targetIdentifier;
    }

    public function getDetails(): array
    {
        // TODO: Implement getTargetDetails() method.
        return [];
    }
}