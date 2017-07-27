<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

class QueueServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testIsAddingJob()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $job->expects($this->any())
            ->method('getPayload')
            ->willReturn('some content');

        $adapterMock = $this->getMock('Linio\Component\Queue\AdapterInterface');
        $adapterMock->expects($this->once())
            ->method('add')
            ->with($this->equalTo($job));

        $queue = new QueueService();
        $queue->setAdapter($adapterMock);

        $this->assertTrue($queue->add($job));
    }

    public function testIsAddingJobWithNonScalarPayload()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job', [], '', true, true, true, ['getPayload', 'setPayload']);
        $job->expects($this->once())
            ->method('getPayload')
            ->willReturn(new \stdClass());
        $job->expects($this->once())
            ->method('setPayload')
            ->with($this->equalTo('{}'));

        $adapterMock = $this->getMock('Linio\Component\Queue\AdapterInterface');
        $adapterMock->expects($this->once())
            ->method('add')
            ->with($this->equalTo($job));

        $queue = new QueueService();
        $queue->setAdapter($adapterMock);
        $this->assertTrue($queue->add($job));
    }

    public function testIsDetectingProblemWhenAddingJob()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');

        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');
        $loggerMock->expects($this->once())
            ->method('error')
            ->with($this->equalTo('[Queue] An error has occurred when adding job: Oops!'), $this->contains('Oops!'));

        $adapterMock = $this->getMock('Linio\Component\Queue\AdapterInterface');
        $adapterMock->expects($this->once())
            ->method('add')
            ->with($job)
            ->will($this->throwException(new \RuntimeException('Oops!')));

        $queue = new QueueService();
        $queue->setAdapter($adapterMock);
        $queue->setLogger($loggerMock);

        $this->assertFalse($queue->add($job));
    }

    public function testIsPerformingJob()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');

        $adapterMock = $this->getMock('Linio\Component\Queue\AdapterInterface');
        $adapterMock->expects($this->once())
            ->method('perform')
            ->with($this->equalTo($job));

        $queue = new QueueService();
        $queue->setAdapter($adapterMock);
        $this->assertTrue($queue->perform($job));
    }

    public function testIsDetectingProblemWhenPerformingJob()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');

        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');
        $loggerMock->expects($this->once())
            ->method('error')
            ->with($this->stringStartsWith('[Queue] An error has occurred while performing'), $this->contains('Oops!'));

        $adapterMock = $this->getMock('Linio\Component\Queue\AdapterInterface');
        $adapterMock->expects($this->once())
            ->method('perform')
            ->with($job)
            ->will($this->throwException(new \RuntimeException('Oops!')));

        $queue = new QueueService();
        $queue->setAdapter($adapterMock);
        $queue->setLogger($loggerMock);

        $this->assertFalse($queue->perform($job));
    }
}
