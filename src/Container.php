<?php

namespace Lagdo\Symfony\Facades;

use Psr\Container\ContainerInterface as PsrContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class Container implements PsrContainerInterface
{
    /**
     * @var ContainerInterface
     */
    private ?ContainerInterface $container = null;

    /**
     * @var ServiceLocator
     */
    private ?ServiceLocator $locator = null;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->locator = $container->get('lagdo.facades.service_locator',
            ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }

    /**
     * @inheritDoc
     */
    public function get(string $serviceId)
    {
        return !$this->locator ? $this->container->get($serviceId) :
            ($this->container->has($serviceId) ? $this->container->get($serviceId) :
                $this->locator->get($serviceId));
    }

    /**
     * @inheritDoc
     */
    public function has(string $serviceId): bool
    {
        return $this->container->has($serviceId) ||
            ($this->locator !== null && $this->locator->has($serviceId));
    }
}
