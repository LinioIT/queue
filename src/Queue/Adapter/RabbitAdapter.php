<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Adapter;

use Linio\Component\Queue\AdapterInterface;
use Linio\Component\Queue\Job;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitAdapter implements AdapterInterface
{
    /**
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * @var array
     */
    protected $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function add(Job $job)
    {
        $this->getChannel()->queue_declare($job->getQueue(), true, $job->isPersistent(), false, false);
        $message = new AMQPMessage($job->getPayload(), ['delivery_mode' => 2]);
        $this->getChannel()->basic_publish($message, '', $job->getQueue());
    }

    public function perform(Job $job)
    {
        $this->getChannel()->queue_declare($job->getQueue(), true, $job->isPersistent(), false, false);
        $this->getChannel()->basic_qos(null, 1, null);
        $this->getChannel()->basic_consume($job->getQueue(), '', false, false, false, false, function ($message) use ($job) {
            $job->setPayload($message->body);
            $job->perform();

            if ($job->isFinished()) {
                $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
            } else {
                $this->channel->basic_nack($message->delivery_info['delivery_tag'], false, true);
            }
        });

        while (count($this->getChannel()->callbacks)) {
            $this->getChannel()->wait();
        }
    }

    public function getChannel(): AMQPChannel
    {
        if (!$this->channel) {
            $connection = new AMQPConnection($this->config['host'], $this->config['port'], $this->config['username'], $this->config['password'], $this->config['vhost']);
            $this->channel = $connection->channel();
        }

        return $this->channel;
    }

    public function setChannel(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }
}
