<?php

namespace Musonza\ActivityStreams\Tests\Helpers;

use Musonza\ActivityStreams\Contracts\ActivityObject;

class SampleObject implements ActivityObject
{
    public function getType(): string
    {
        return 'photo.album';
    }

    public function getIdentifier(): string
    {
        return 'tag:example.org,2011:abc123';
    }

    public function getExtraData(): array
    {
        return [];
    }
}