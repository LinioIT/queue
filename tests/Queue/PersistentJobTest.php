<?php

namespace Linio\Component\Queue;

class PersistentJobTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCheckingPersistence()
    {
        $job = $this->getMockForAbstractClass('Linio\Component\Queue\PersistentJob');
        $this->assertTrue($job->isPersistent());
    }
}
