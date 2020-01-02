<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Adapter;

use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;

class RabbitAdapterTest extends TestCase
{
    public function testIsAddingJob(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job', [], '', false, false, true, ['getQueue', 'getPayload']);
        $job->expects($this->exactly(2))
            ->method('getQueue')
            ->will($this->returnValue('foobar'));
        $job->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue('bar'));

        $message = new AMQPMessage('bar', ['delivery_mode' => 2]);

        $channelMock = $this->getMockBuilder('PhpAmqpLib\Channel\AMQPChannel')
            ->disableOriginalConstructor()
            ->getMock();
        $channelMock->expects($this->once())
            ->method('queue_declare')
            ->with($this->equalTo('foobar'), $this->equalTo(true), $this->equalTo(false), $this->equalTo(false), $this->equalTo(false));
        $channelMock->expects($this->once())
            ->method('basic_publish')
            ->with($this->equalTo($message), $this->equalTo(''), $this->equalTo('foobar'));

        $adapterMock = $this->getMockBuilder('Linio\Component\Queue\Adapter\RabbitAdapter')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $adapterMock->setChannel($channelMock);

        $this->assertNull($adapterMock->add($job));
    }

    public function testIsPerformingJob(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job', [], '', false, false, true, ['getQueue', 'getPayload']);
        $job->expects($this->exactly(2))
            ->method('getQueue')
            ->will($this->returnValue('foobar'));

        $channelMock = $this->getMockBuilder('PhpAmqpLib\Channel\AMQPChannel')
            ->disableOriginalConstructor()
            ->getMock();
        $channelMock->expects($this->once())
            ->method('queue_declare')
            ->with($this->equalTo('foobar'), $this->equalTo(true), $this->equalTo(false), $this->equalTo(false), $this->equalTo(false));
        $channelMock->expects($this->once())
            ->method('basic_qos')
            ->with($this->equalTo(null), $this->equalTo(1), $this->equalTo(null));
        $channelMock->expects($this->once())
            ->method('basic_consume')
            ->with($this->equalTo('foobar'));

        $adapterMock = $this->getMockBuilder('Linio\Component\Queue\Adapter\RabbitAdapter')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $adapterMock->setChannel($channelMock);

        $this->assertNull($adapterMock->perform($job));
    }
}
