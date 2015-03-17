<?php

namespace Linio\Component\Queue;

trait QueueTrait
{
    /**
     * @var QueueService
     */
    protected $queue;

    /**
     * @return QueueService
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param QueueService $queue
     */
    public function setQueue(QueueService $queue)
    {
        $this->queue = $queue;
    }
}
