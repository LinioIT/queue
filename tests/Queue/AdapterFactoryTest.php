<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

use PHPUnit\Framework\TestCase;

class AdapterFactoryTest extends TestCase
{
    public function testIsGettingAdapter(): void
    {
        $adapterFactory = new AdapterFactory();
        $adapter = $adapterFactory->getAdapter('null', ['foo' => 'bar']);
        $this->assertInstanceOf('Linio\Component\Queue\Adapter\NullAdapter', $adapter);
    }

    public function testIsDetectingBadAdapter(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $adapterFactory = new AdapterFactory();
        $adapter = $adapterFactory->getAdapter('foobar', ['foo' => 'bar']);
    }
}
