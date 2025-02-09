<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class Container
{
    /**
     * @var ContainerInterface
     */
    private static $container = null;

    /**
     * @var ServiceLocator
     */
    private static $locator = null;

    /**
     * @param ContainerInterface $container
     *
     * @return void
     */
    public static function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
        self::$locator = $container->get('lagdo.facades.service_locator',
            ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }

    /**
     * Get a service using the container or the locator.
     *
     * @param string $serviceId
     *
     * @return mixed
     */
    public static function getFacadeService(string $serviceId): mixed
    {
        return self::$container->has($serviceId) ?
            // A public service will be found in the container.
            self::$container->get($serviceId) :
            // If not found in the container, then look in the service locator.
            (self::$locator !== null && self::$locator->has($serviceId) ?
                self::$locator->get($serviceId) : null);
    }
}
