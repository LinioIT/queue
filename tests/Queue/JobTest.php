<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

class JobTest extends \PHPUnit\Framework\TestCase
{
    public function testIsCheckingPersistence(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $this->assertFalse($job->isPersistent());
    }

    public function testIsGettingQueueName(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $this->assertStringStartsWith('Mock_Job_', $job->getQueue());
    }

    public function testIsSettingScalarPayload(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $job->setPayload('foobar');
        $this->assertEquals('foobar', $job->getPayload());
    }

    public function testIsConstructingWithPayload(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $job->__construct('foobar');
        $this->assertEquals('foobar', $job->getPayload());
    }

    public function testIsSettingStatus(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $job->finish();
        $this->assertTrue($job->isFinished());
        $job->fail();
        $this->assertFalse($job->isFinished());
    }
}
