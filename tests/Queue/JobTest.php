<?php

namespace Linio\Component\Queue;

class JobTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCheckingPersistence()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $this->assertFalse($job->isPersistent());
    }

    public function testIsGettingQueueName()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $this->assertStringStartsWith('Mock_Job_', $job->getQueue());
    }

    public function testIsSettingScalarPayload()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $job->setPayload('foobar');
        $this->assertEquals('foobar', $job->getPayload());
    }

    public function testIsConstructingWithPayload()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $job->__construct('foobar');
        $this->assertEquals('foobar', $job->getPayload());
    }

    public function testIsSettingStatus()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $job->finish();
        $this->assertTrue($job->isFinished());
        $job->fail();
        $this->assertFalse($job->isFinished());
    }
}
