<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

class PersistentJobTest extends \PHPUnit\Framework\TestCase
{
    public function testIsCheckingPersistence(): void
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\PersistentJob');
        $this->assertTrue($job->isPersistent());
    }
}
