<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class Container
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get a service from the container.
     *
     * @param string $serviceId
     *
     * @return mixed|null
     */
    private function get(string $serviceId)
    {
        return $this->container->get($serviceId, ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }

    /**
     * Get the locator.
     *
     * @return ServiceLocator
     */
    private function locator()
    {
        return $this->get('lagdo.facades.service_locator');
    }

    /**
     * Get a service using the container or the locator.
     *
     * @param string $serviceId
     *
     * @return mixed|null
     */
    public function getService(string $serviceId)
    {
        if(($service = $this->get($serviceId)) !== null)
        {
            return $service;
        }
        if(($locator = $this->locator()) !== null && $locator->has($serviceId))
        {
            return $locator->get($serviceId);
        }
        return null;
    }
}
