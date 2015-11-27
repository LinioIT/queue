<?php
declare(strict_types=1);

namespace Linio\Component\Queue;

abstract class PersistentJob extends Job
{
    public function isPersistent(): bool
    {
        return true;
    }
}
