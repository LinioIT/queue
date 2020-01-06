<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Adapter;

use Linio\Component\Queue\AdapterInterface;
use Linio\Component\Queue\Job;

class NullAdapter implements AdapterInterface
{
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function add(Job $job): void
    {
    }

    public function perform(Job $job): void
    {
    }
}
