<?php

namespace Lagdo\Symfony\Facades;

abstract class AbstractFacade
{
    /**
     * Get the service id.
     *
     * @return string
     */
    abstract protected static function getServiceIdentifier();

    /**
     * Call the service.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $method, array $arguments)
    {
        return Container::getService(static::getServiceIdentifier())->$method(...$arguments);
    }
}
