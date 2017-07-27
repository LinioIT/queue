<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Adapter;

class NullAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testIsAddingJob()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $adapter = new NullAdapter();
        $this->assertNull($adapter->add($job));
    }

    public function testIsPerformingJob()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $adapter = new NullAdapter();
        $this->assertNull($adapter->perform($job));
    }
}
