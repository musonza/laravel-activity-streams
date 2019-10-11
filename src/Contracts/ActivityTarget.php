<?php

namespace Musonza\ActivityStreams\Contracts;

interface ActivityTarget
{
    public function getType(): string ;
    public function getIdentifier(): string ;
    public function getExtraData(): array ;
}