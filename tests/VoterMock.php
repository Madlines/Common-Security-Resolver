<?php

namespace Madlines\Common\SecurityResolver\Tests;

class VoterMock
{
    public function isGranted($user, $task)
    {
        return true;
    }

    private function foo($user, $task)
    {
        return null;
    }
}
