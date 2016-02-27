<?php

namespace Madlines\Common\SecurityResolver\Tests;

class IntegerVoterMock
{
    public function isGranted($user, $task)
    {
        return 1;
    }

    private function foo($user, $task)
    {
        return 0;
    }
}
