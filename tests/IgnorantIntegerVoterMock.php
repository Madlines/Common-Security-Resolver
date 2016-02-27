<?php

namespace Madlines\Common\SecurityResolver\Tests;

class IgnorantIntegerVoterMock
{
    public function isGranted($user, $task)
    {
        return 0;
    }
}
