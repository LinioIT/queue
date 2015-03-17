<?php

namespace Linio\Component\Queue;

use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Linio\Component\Util\Json;

class QueueService
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Job $job
     *
     * @return boolean
     */
    public function add(Job $job)
    {
        try {
            $this->prepare($job);
            $this->adapter->add($job);
        } catch (\Exception $e) {
            $this->logger->error('[Queue] An error has occurred when adding job: ' . $e->getMessage(), (array) $e);

            return false;
        }

        return true;
    }

    /**
     * @param Job $job
     *
     * @return boolean
     */
    public function perform(Job $job)
    {
        try {
            $this->adapter->perform($job);
        } catch (\Exception $e) {
            $message = sprintf('[Queue] An error has occurred while performing "%s": %s', get_class($job), $e->getMessage());
            $this->logger->error($message, (array) $e);

            return false;
        }

        return true;
    }

    /**
     * @param Job $job
     */
    protected function prepare(Job $job)
    {
        $payload = $job->getPayload();

        if ($payload && !is_scalar($payload)) {
            $job->setPayload(Json::encode($payload));
        }
    }

    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
