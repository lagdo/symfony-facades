<?php

namespace Lagdo\Symfony\Facades;

abstract class AbstractFacade
{
    /**
     * Get the service identifier.
     *
     * @return string
     */
    abstract protected static function getServiceIdentifier();

    /**
     * Get the service instance.
     *
     * @return mixed
     */
    public static function instance()
    {
        return FacadesBundle::getFacadeContainer()->getService(static::getServiceIdentifier());
    }

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
        // Get the instance and call the method.
        return self::instance()->$method(...$arguments);
    }
}
