<?php

declare(strict_types=1);

namespace Linio\Component\Queue;

use Exception;
use Linio\Component\Queue\Adapter\NullAdapter;
use Linio\Component\Util\Json;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class QueueService
{
    protected AdapterInterface $adapter;
    protected LoggerInterface $logger;

    public function __construct()
    {
        $this->adapter = new NullAdapter();
        $this->logger = new NullLogger();
    }

    public function add(Job $job): bool
    {
        try {
            $this->prepare($job);
            $this->adapter->add($job);
        } catch (Exception $e) {
            $this->logger->error('[Queue] An error has occurred when adding job: ' . $e->getMessage(), (array) $e);

            return false;
        }

        return true;
    }

    public function perform(Job $job): bool
    {
        try {
            $this->adapter->perform($job);
        } catch (Exception $e) {
            $message = sprintf('[Queue] An error has occurred while performing "%s": %s', get_class($job), $e->getMessage());
            $this->logger->error($message, (array) $e);

            return false;
        }

        return true;
    }

    protected function prepare(Job $job): void
    {
        $payload = $job->getPayload();

        if ($payload && !is_scalar($payload)) {
            $job->setPayload(Json::encode($payload));
        }
    }

    public function setAdapter(AdapterInterface $adapter): void
    {
        $this->adapter = $adapter;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
