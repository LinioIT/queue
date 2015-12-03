<?php
declare(strict_types=1);

namespace Linio\Component\Queue;

abstract class Job
{
    /**
     * @var bool
     */
    protected $status = false;

    /**
     * @var mixed
     */
    protected $payload;

    public function __construct($payload = null)
    {
        if (!$payload) {
            return;
        }

        $this->setPayload($payload);
    }

    public function getQueue(): string
    {
        return get_class($this);
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    public function isPersistent(): bool
    {
        return false;
    }

    public function isFinished(): bool
    {
        return $this->status;
    }

    public function fail()
    {
        $this->status = false;
    }

    public function finish()
    {
        $this->status = true;
    }

    abstract public function perform();
}
