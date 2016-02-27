<?php

namespace Madlines\Common\SecurityResolver\Tests;

class BooleanVoterMock
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
