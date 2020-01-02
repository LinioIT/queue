<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Adapter;

use PHPUnit\Framework\TestCase;

class NullAdapterTest extends TestCase
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
