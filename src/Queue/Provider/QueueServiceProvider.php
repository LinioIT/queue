<?php

declare(strict_types=1);

namespace Linio\Component\Queue\Provider;

use Linio\Component\Queue\AdapterFactory;
use Linio\Component\Queue\QueueService;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class QueueServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        if (!isset($container['queue.adapter_name'])) {
            $container['queue.adapter_name'] = 'null';
        }

        $container['queue.adapter'] = $container->factory(function ($container) {
            $adapterFactory = new AdapterFactory();

            return $adapterFactory->getAdapter($container['queue.adapter_name'], $container['queue.adapter_options']);
        });

        $container['queue.service'] = function ($container) {
            $queueService = new QueueService();
            $queueService->setAdapter($container['queue.adapter']);
            $queueService->setLogger($container['monolog']);

            return $queueService;
        };
    }
}
