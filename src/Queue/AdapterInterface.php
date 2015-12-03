<?php
declare(strict_types=1);

namespace Linio\Component\Queue;

interface AdapterInterface
{
    public function __construct(array $config);
    public function add(Job $job);
    public function perform(Job $job);
}
