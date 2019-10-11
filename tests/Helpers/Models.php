<?php

namespace Musonza\ActivityStreams\Tests\Helpers\Models;

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Contracts\ReturnsExtraData;
use Musonza\ActivityStreams\Traits\HasFeed;

class User extends Model implements ReturnsExtraData
{
    use HasFeed;

    public function getExtraData()
    {
        return [
            'title' => 'This is a test',
        ];
    }
}

class Blog extends Model {}