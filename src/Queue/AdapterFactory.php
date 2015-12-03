<?php
declare(strict_types=1);

namespace Linio\Component\Queue;

use Linio\Component\Util\Inflector;

class AdapterFactory
{
    public function getAdapter(string $adapterName, array $adapterConfig = []): AdapterInterface
    {
        $adapterClass = sprintf('%s\\Adapter\\%sAdapter', __NAMESPACE__, Inflector::pascalize($adapterName));

        if (!class_exists($adapterClass)) {
            throw new \InvalidArgumentException('Adapter class does not exist: ' . $adapterClass);
        }

        $adapter = new $adapterClass($adapterConfig);

        return $adapter;
    }
}
