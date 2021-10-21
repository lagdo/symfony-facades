<?php

namespace Lagdo\Symfony\Facades;

abstract class AbstractFacade
{
    /**
     * @var mixed
     */
    protected static $service = null;

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
    public static function __callStatic($method, $arguments)
    {
        if(static::$service === null)
        {
            static::$service = Container::getService(static::getServiceIdentifier());
        }
        return \call_user_func_array([static::$service, $method], $arguments);
    }
}
