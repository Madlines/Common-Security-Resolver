<?php

namespace Madlines\Common\SecurityResolver\Tests;

use Madlines\Common\SecurityResolver\VoterContainer;

class VoterContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildWithNoObject()
    {
        new VoterContainer('foo', 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildWithWrongMethodName()
    {
        new VoterContainer(new \StdClass(), 'foo');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildWithPrivateIsGrantedMethod()
    {
        $voter = new VoterMock();
        new VoterContainer($voter, 'foo');
    }

    public function testIsGranted()
    {
        $voter = new VoterMock();
        $container = new VoterContainer($voter, 'isGranted');

        $this->assertTrue($container->isGranted(new \StdClass(), new \StdClass()));
    }
}
