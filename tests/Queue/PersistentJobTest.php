<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

use PHPUnit\Framework\TestCase;

class PersistentJobTest extends TestCase
{
    public function testIsCheckingPersistence(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\PersistentJob');
        $this->assertTrue($job->isPersistent());
    }
}
