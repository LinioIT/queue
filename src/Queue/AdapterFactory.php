<?php

namespace Linio\Component\Queue;

use Linio\Component\Util\String;

class AdapterFactory
{
    /**
     * @param string $adapterName
     * @param array $adapterConfig
     * @return AdapterInterface
     */
    public function getAdapter($adapterName, $adapterConfig = array())
    {
        $adapterClass = sprintf('%s\\Adapter\\%sAdapter', __NAMESPACE__, String::pascalize($adapterName));

        if (!class_exists($adapterClass)) {
            throw new \InvalidArgumentException('Adapter class does not exist: ' . $adapterClass);
        }

        $adapter = new $adapterClass($adapterConfig);

        return $adapter;
    }
}
