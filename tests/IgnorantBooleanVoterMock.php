<?php

namespace Madlines\Common\SecurityResolver\Tests;

class IgnorantBooleanVoterMock
{
    public function isGranted($user, $task)
    {
        return null;
    }
}
