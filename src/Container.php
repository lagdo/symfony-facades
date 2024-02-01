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
     * @param ContainerInterface $container
     */
    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }

    /**
     * Get a service using the container or the locator.
     *
     * @param string $serviceId
     *
     * @return mixed|null
     */
    public static function getFacadeService(string $serviceId)
    {
        if(self::$container->has($serviceId))
        {
            // A public service will be found in the container.
            return self::$container->get($serviceId);
        }

        // If not found in the container, then look in the service locator.
        /** @var ServiceLocator */
        $locator = self::$container->get('lagdo.facades.service_locator',
            ContainerInterface::NULL_ON_INVALID_REFERENCE);
        return ($locator !== null && $locator->has($serviceId)) ? $locator->get($serviceId) : null;
    }
}
