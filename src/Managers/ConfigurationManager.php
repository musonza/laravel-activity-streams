<?php

namespace Musonza\ActivityStreams\Managers;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Musonza\ActivityStreams\Exceptions\InvalidActivityVerbException;
use Musonza\ActivityStreams\ValueObjects\Verbs;
use ReflectionClass;

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
        if (!in_array($verb, $this->getVerbs())) {
            throw new InvalidActivityVerbException(sprintf('Invalid verb provided: %s', $verb));
        }
    }

    public function getVerbs()
    {
        $verbsDefinitions = new ReflectionClass(Verbs::class);
        $verbs = array_merge($verbsDefinitions->getConstants(), $this->configuration['verbs']);

        return $verbs;
    }
}