<?php

namespace Musonza\ActivityStreams\Tests\Unit;

use Musonza\ActivityStreams\Tests\TestCase;
use Musonza\ActivityStreams\ActivityStreamsFacade as ActivityStreams;

class FacadeTest extends TestCase
{
    public function testGetDefinedVerbs()
    {
        $verbs = ActivityStreams::verbs();

        $this->assertIsArray($verbs);
        $this->assertEquals('post', $verbs['VERB_POST']);
    }

}