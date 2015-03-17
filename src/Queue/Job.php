<?php

namespace Linio\Component\Queue;

abstract class Job
{
    /**
     * @var boolean
     */
    protected $status = false;

    /**
     * @var mixed
     */
    protected $payload;

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

    /**
     * @return string
     */
    public function getQueue()
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
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return boolean
     */
    public function isPersistent()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isFinished()
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

    /**
     * @return void
     */
    abstract public function perform();
}
