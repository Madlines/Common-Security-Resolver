<?php

namespace Madlines\Common\SecurityResolver\Tests;

use Madlines\Common\SecurityResolver\AccessResolver;

class AccessResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testIsGranted()
    {
        $user = new \StdClass();
        $task = new \StdClass();

        // should grant access if there are no voters
        $resolver = new AccessResolver();
        $this->assertTrue($resolver->isGranted($user, $task));

        // should grant access if there is agreeing voter
        $resolver2 = new AccessResolver();
        $resolver2->addVoter(new BooleanVoterMock());

        $this->assertTrue($resolver2->isGranted($user, $task));

        // should not grant access if there is an not agreeing voter
        $resolver3 = new AccessResolver();
        $resolver3->addVoter(new NotAgreeingBooleanVoterMock());

        $this->assertFalse($resolver3->isGranted($user, $task));

        // should not grant access if there is at least one not agreeing voter
        $resolver4 = new AccessResolver();
        $resolver4->addVoter(new BooleanVoterMock());
        $resolver4->addVoter(new NotAgreeingBooleanVoterMock());

        $this->assertFalse($resolver4->isGranted($user, $task));

        // should not grant access if there is at least one not agreeing voter
        $resolver5 = new AccessResolver();
        $resolver5->addVoter(new NotAgreeingBooleanVoterMock());
        $resolver5->addVoter(new BooleanVoterMock());

        $this->assertFalse($resolver5->isGranted($user, $task));

        // should grant access if there is not at least one not agreeing voter
        $resolver6 = new AccessResolver();
        $resolver6->addVoter(new IgnorantBooleanVoterMock());
        $resolver6->addVoter(new BooleanVoterMock());

        $this->assertTrue($resolver6->isGranted($user, $task));

        // should grant access if there is not at least one not agreeing voter
        $resolver7 = new AccessResolver();
        $resolver7->addVoter(new IgnorantBooleanVoterMock());
        $resolver7->addVoter(new IgnorantBooleanVoterMock());

        $this->assertTrue($resolver7->isGranted($user, $task));

        // should not grant access if there is at least one not agreeing voter
        $resolver8 = new AccessResolver();
        $resolver8->addVoter(new IgnorantBooleanVoterMock());
        $resolver8->addVoter(new NotAgreeingBooleanVoterMock());

        $this->assertFalse($resolver8->isGranted($user, $task));
    }
}
