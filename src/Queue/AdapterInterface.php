<?php

namespace Linio\Component\Queue;

interface AdapterInterface
{
    /**
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @param Job $job
     *
     * @return void
     */
    public function add(Job $job);

    /**
     * @param Job $job
     *
     * @return void
     */
    public function perform(Job $job);
}
