<?php

namespace Linio\Component\Queue\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Linio\Component\Queue\QueueService;
use Linio\Component\Queue\AdapterFactory;

class QueueServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        if (!isset($container['queue.adapter_name'])) {
            $container['queue.adapter_name'] = 'null';
        }

        $container['queue.adapter'] = $container->factory(function ($container) {
            $adapterFactory = new AdapterFactory();
            $adapter = $adapterFactory->getAdapter($container['queue.adapter_name'], $container['queue.adapter_options']);

            return $adapter;
        });

        $container['queue.service'] = function ($container) {
            $queueService = new QueueService();
            $queueService->setAdapter($container['queue.adapter']);
            $queueService->setLogger($container['monolog']);

            return $queueService;
        };
    }
}
