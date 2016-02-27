<?php

namespace Madlines\Common\SecurityResolver\Tests;

class NotAgreeingIntegerVoterMock
{
    public function isGranted($user, $task)
    {
        return -1;
    }
}
