<?php

namespace Madlines\Common\SecurityResolver\Tests;

class IgnorantVoterMock
{
    public function isGranted($user, $task)
    {
        return null;
    }
}
