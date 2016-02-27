<?php

namespace Madlines\Common\SecurityResolver\Tests;

class NotAgreeingBooleanVoterMock
{
    public function isGranted($user, $task)
    {
        return false;
    }
}
