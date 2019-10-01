<?php

namespace Musonza\ActivityStreams\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'actor_type',
        'actor_id',
        'verb',
        'target_type',
        'target_id',
        'target',
        'object',
    ];
}