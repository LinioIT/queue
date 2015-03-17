<?php

namespace Linio\Component\Queue\Adapter;

use Linio\Component\Queue\AdapterInterface;
use Linio\Component\Queue\Job;

class NullAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
    }

    /**
     * {@inheritdoc}
     */
    public function add(Job $job)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function perform(Job $job)
    {
        return;
    }
}
