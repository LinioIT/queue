<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

abstract class Job
{
    protected bool $status = false;

    /**
     * @var mixed
     */
    protected $payload = null;

    /**
     * @param mixed $payload
     */
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

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     */
    public function setPayload($payload): void
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

    public function fail(): void
    {
        $this->status = false;
    }

    public function finish(): void
    {
        $this->status = true;
    }

    abstract public function perform(): void;
}
