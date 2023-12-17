<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class Container
{
    /**
     * @var Container
     */
    private static $instance = null;

    /**
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * @param ContainerInterface $container
     */
    private function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get a service using the container or the locator.
     *
     * @param string $serviceId
     *
     * @return mixed|null
     */
    private function getService(string $serviceId)
    {
        if($this->container->has($serviceId))
        {
            // A public service will be found in the container.
            return $this->container->get($serviceId);
        }

        /**
         * @var ServiceLocator
         */
        $locator = $this->container->get('lagdo.facades.service_locator',
            ContainerInterface::NULL_ON_INVALID_REFERENCE);
        // If not found in the container, then look in the service locator.
        if($locator !== null && $locator->has($serviceId))
        {
            return $locator->get($serviceId);
        }

        return null;
    }

    /**
     * @param ContainerInterface $container
     */
    public static function createInstance(ContainerInterface $container)
    {
        self::$instance = new Container($container);
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
        return self::$instance->getService($serviceId);
    }
}
