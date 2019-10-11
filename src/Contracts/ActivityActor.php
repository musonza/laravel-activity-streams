<?php

namespace Musonza\ActivityStreams\Contracts;

interface ActivityActor
{
    public function getType(): string ;
    public function getIdentifier(): string ;
    public function getExtraData(): array ;
}