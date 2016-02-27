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
        $voter = new BooleanVoterMock();
        new VoterContainer($voter, 'foo');
    }

    public function testIsGranted()
    {
        $voter = new BooleanVoterMock();
        $container = new VoterContainer($voter, 'isGranted');

        $this->assertTrue($container->isGranted(new \StdClass(), new \StdClass()));
    }

    public function testHandlingAVotersReturningIntegerValues()
    {
        $voter = new IntegerVoterMock();
        $container = new VoterContainer($voter, 'isGranted');

        $this->assertTrue($container->isGranted(new \StdClass(), new \StdClass()));

        $voter = new IgnorantIntegerVoterMock();
        $container = new VoterContainer($voter, 'isGranted');

        $this->assertNull($container->isGranted(new \StdClass(), new \StdClass()));

        $voter = new NotAgreeingIntegerVoterMock();
        $container = new VoterContainer($voter, 'isGranted');

        $this->assertFalse($container->isGranted(new \StdClass(), new \StdClass()));
    }

    public function improperReturnValues()
    {
        return [
            [new \StdClass],
            [2],
            [-2],
            [[]],
        ];
    }

    /**
     * @dataProvider improperReturnValues
     * @expectedException \RuntimeException
     */
    public function testVoterWhichReturnsValuesFromOutsideAllowedScope($value)
    {
        $voter = $this->getMock(\StdClass::class, ['isGranted']);
        $voter->method('isGranted')->willReturn($value);

        $container = new VoterContainer($voter, 'isGranted');
        $container->isGranted(new \StdClass(), new \StdClass());
    }
}
