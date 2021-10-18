<?php

namespace Lagdo\Symfony\Facades;

use Psr\Container\ContainerInterface as PsrContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractFacade
{
    /**
     * @var ContainerInterface
     */
    protected static $container = null;

    /**
     * @var PsrContainerInterface
     */
    protected static $locator = null;

    /**
     * Set the container and locator
     *
     * @param ContainerInterface $container
     * @param PsrContainerInterface $locator
     *
     * @return void
     */
    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
        self::$locator = $container->get('lagdo.service_locator', ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }

    /**
     * Get the service id.
     *
     * @return string
     */
    abstract protected static function getServiceId();

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
        $serviceId = static::getServiceId();
        $service = self::$container->get($serviceId, ContainerInterface::NULL_ON_INVALID_REFERENCE);
        if($service === null && self::$locator !== null && self::$locator->has($serviceId))
        {
            $service = self::$locator->get($serviceId);
        }
        return \call_user_func_array([$service, $method], $arguments);
    }
}
