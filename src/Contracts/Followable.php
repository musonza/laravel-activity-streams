<?php

namespace Musonza\ActivityStreams\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Followable
{
    public function follow(Model $followable);
    public function follows(): MorphMany;
}