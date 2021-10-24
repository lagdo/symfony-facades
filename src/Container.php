<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class Container
{
    /**
     * @var array
     */
    private static $services = [];

    /**
     * @var ContainerInterface
     */
    protected static $container = null;

    /**
     * @var ServiceLocator
     */
    protected static $locator = null;

    /**
     * Get a service using the container or the locator.
     *
     * @param string $serviceId
     *
     * @return mixed|null
     */
    public static function getService(string $serviceId)
    {
        $service = isset(self::$services[$serviceId]) ? self::$services[$serviceId] : null;
        if($service === null)
        {
            $service = self::$container->get($serviceId, ContainerInterface::NULL_ON_INVALID_REFERENCE);
            if($service === null && self::$locator !== null && self::$locator->has($serviceId))
            {
                $service = self::$locator->get($serviceId);
            }
            // If a service is found, save it locally.
            if($service !== null)
            {
                self::$services[$serviceId] = $service;
            }
        }
        return $service;
    }

    /**
     * Set the container and locator.
     *
     * @param ContainerInterface $container
     *
     * @return void
     */
    public static function init(ContainerInterface $container)
    {
        self::$services = [];
        self::$container = $container;
        self::$locator = null;
        self::$locator = self::getService('lagdo.facades.service_locator');
    }
}
