<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Adapter;

class NullAdapterTest extends \PHPUnit\Framework\TestCase
{
    public function testIsAddingJob(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $adapter = new NullAdapter();
        $this->assertNull($adapter->add($job));
    }

    public function testIsPerformingJob(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\Job');
        $adapter = new NullAdapter();
        $this->assertNull($adapter->perform($job));
    }
}
