<?php

namespace Linio\Component\Queue;

abstract class PersistentJob extends Job
{
    public function isPersistent()
    {
        return true;
    }
}
