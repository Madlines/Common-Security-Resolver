<?php

namespace Madlines\Common\SecurityResolver;

class AccessResolver
{
    /**
     * @var VoterContainer[]
     */
    private $voters = [];

    /**
     * @param object $voter
     * @param string $method
     * @return $this
     */
    public function addVoter($voter, $method = 'isGranted')
    {
        $this->voters[] = new VoterContainer($voter, $method);
        return $this;
    }

    /**
     * @param object $user
     * @param mixed $task
     * @return bool
     */
    public function isGranted($user, $task)
    {
        foreach($this->voters as $voter) {
            $isGranted = $voter->isGranted($user, $task);

            // if one of voters says no - user cannot perform this task
            if (false === $isGranted) {
                return false;
            }
        }

        return true;
    }
}
