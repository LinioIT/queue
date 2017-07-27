<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

trait QueueAware
{
    /**
     * @var QueueService
     */
    protected $queue;

    public function getQueue(): QueueService
    {
        return $this->queue;
    }

    public function setQueue(QueueService $queue)
    {
        $this->queue = $queue;
    }
}
