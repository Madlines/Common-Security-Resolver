<?php

namespace Madlines\Common\SecurityResolver;

class VoterContainer
{
    /**
     * @var object
     */
    private $voter;

    /**
     * @var string
     */
    private $method;

    /**
     * @param object $voter
     * @param string $method
     */
    public function __construct($voter, $method)
    {
        // We use some duck typing here so voters won't depend on this library in any way
        if (!is_object($voter)) {
            throw new \InvalidArgumentException('$voter has to be an object.');
        }

        $reflection = new \ReflectionObject($voter);
        if (!$reflection->hasMethod($method) || !$reflection->getMethod($method)->isPublic()) {
            throw new \InvalidArgumentException('$voter has to be an object which has a public method called ' . $method);
        }

        $this->voter = $voter;
        $this->method = $method;
    }

    /**
     * @param mixed $user
     * @param mixed $task
     * @return bool|null
     */
    public function isGranted($user, $task)
    {
        $result = $this->voter->{$this->method}($user, $task);

        if (is_null($result) || 0 === $result) {
            return null;
        }

        if (false === $result || -1 === $result) {
            return false;
        }

        if (true === $result || 1 === $result) {
            return true;
        }

        throw new \RuntimeException('Voter has to return one of the following values: true, false, bool, 1, -1 or 0.');
    }
}
