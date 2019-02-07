<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Adapter;

use Linio\Component\Queue\AdapterInterface;
use Linio\Component\Queue\Job;

class NullAdapter implements AdapterInterface
{
    public function __construct(array $config = [])
    {
    }

    public function add(Job $job): void
    {
    }

    public function perform(Job $job): void
    {
    }
}
