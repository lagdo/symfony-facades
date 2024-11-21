<?php

namespace Lagdo\Symfony\Facades;

abstract class AbstractFacade
{
    /**
     * Get the service identifier.
     *
     * @return string
     */
    abstract protected static function getServiceIdentifier(): string;

    /**
     * Get the service instance.
     *
     * @return mixed
     */
    public static function instance(): mixed
    {
        return Container::getFacadeService(static::getServiceIdentifier());
    }

    /**
     * Call the service.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $method, array $arguments): mixed
    {
        // Get the instance and call the method.
        return self::instance()->$method(...$arguments);
    }
}
