<?php

namespace Musonza\ActivityStreams\Managers;

use Illuminate\Config\Repository;
use Musonza\ActivityStreams\Exceptions\InvalidActivityVerbException;

class ConfigurationManager
{
    /**
     * @var Repository
     */
    private $configuration;

    public function __construct()
    {
        $this->configuration = config('activity_streams');
    }

    /**
     * @param string $verb
     * @throws InvalidActivityVerbException
     */
    public function validateVerb(string $verb)
    {
        if (!in_array($verb, $this->configuration['verbs'])) {
            throw new InvalidActivityVerbException(sprintf('Invalid verb provided: %s', $verb));
        }
    }

    public function getVerbs()
    {
        return $this->configuration['verbs'];
    }
}