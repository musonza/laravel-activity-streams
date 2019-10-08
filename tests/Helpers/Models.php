<?php

namespace Musonza\ActivityStreams\Tests\Helpers\Models;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Traits\HasFeed;

class User extends Model
{
    use HasFeed;
}

class Blog extends Model {}