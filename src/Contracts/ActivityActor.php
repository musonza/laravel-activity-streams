<?php

namespace Musonza\ActivityStreams\Contracts;

interface ActivityActor
{
    public function getActorType(): string ;
    public function getActorIdentifier(): string ;
    public function getActorDetails(): array ;
}