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
        $resolver2->addVoter(new VoterMock());

        $this->assertTrue($resolver2->isGranted($user, $task));

        // should not grant access if there is an not agreeing voter
        $resolver3 = new AccessResolver();
        $resolver3->addVoter(new NotAgreeingVoterMock());

        $this->assertFalse($resolver3->isGranted($user, $task));

        // should not grant access if there is at least one not agreeing voter
        $resolver4 = new AccessResolver();
        $resolver4->addVoter(new VoterMock());
        $resolver4->addVoter(new NotAgreeingVoterMock());

        $this->assertFalse($resolver4->isGranted($user, $task));

        // should not grant access if there is at least one not agreeing voter
        $resolver5 = new AccessResolver();
        $resolver5->addVoter(new NotAgreeingVoterMock());
        $resolver5->addVoter(new VoterMock());

        $this->assertFalse($resolver5->isGranted($user, $task));

        // should grant access if there is not at least one not agreeing voter
        $resolver6 = new AccessResolver();
        $resolver6->addVoter(new IgnorantVoterMock());
        $resolver6->addVoter(new VoterMock());

        $this->assertTrue($resolver6->isGranted($user, $task));

        // should grant access if there is not at least one not agreeing voter
        $resolver7 = new AccessResolver();
        $resolver7->addVoter(new IgnorantVoterMock());
        $resolver7->addVoter(new IgnorantVoterMock());

        $this->assertTrue($resolver7->isGranted($user, $task));

        // should not grant access if there is at least one not agreeing voter
        $resolver8 = new AccessResolver();
        $resolver8->addVoter(new IgnorantVoterMock());
        $resolver8->addVoter(new NotAgreeingVoterMock());

        $this->assertFalse($resolver8->isGranted($user, $task));
    }
}
