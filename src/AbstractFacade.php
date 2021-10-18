<?php

namespace Lagdo\Symfony\Facades;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

abstract class AbstractFacade
{
    /**
     * @var Container
     */
    protected static $container = null;

    /**
     * @var ContainerInterface
     */
    protected static $locator = null;

    /**
     * @var mixed
     */
    protected static $service = null;

    /**
     * Get a service using the container
     *
     * @param string $serviceId
     *
     * @return mixed|null
     */
    private static function _getServiceWithContainer(string $serviceId)
    {
        return self::$container->get($serviceId, Container::NULL_ON_INVALID_REFERENCE);
    }

    /**
     * Get a service using the locator
     *
     * @param string $serviceId
     *
     * @return mixed|null
     */
    private static function _getServiceWithLocator(string $serviceId)
    {
        if(self::$locator === null || !self::$locator->has($serviceId))
        {
            return null;
        }
        return self::$locator->get($serviceId);
    }

    /**
     * Set the container and locator
     *
     * @param Container $container
     *
     * @return void
     */
    public static function setServiceContainer(Container $container)
    {
        self::$container = $container;
        self::$locator = self::_getServiceWithContainer('lagdo.service_locator');
    }

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
            $serviceId = static::getServiceIdentifier();
            static::$service = self::_getServiceWithContainer($serviceId);
            if(static::$service === null)
            {
                static::$service = self::_getServiceWithLocator($serviceId);
            }
        }
        return \call_user_func_array([static::$service, $method], $arguments);
    }
}
