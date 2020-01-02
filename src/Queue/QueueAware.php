<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

trait QueueAware
{
    protected QueueService $queue;

    public function getQueue(): QueueService
    {
        return $this->queue;
    }

    public function setQueue(QueueService $queue): void
    {
        $this->queue = $queue;
    }
}
