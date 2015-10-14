<?php

namespace Madlines\Common\SecurityResolver\Tests;

class NotAgreeingVoterMock
{
    public function isGranted($user, $task)
    {
        return false;
    }
}
