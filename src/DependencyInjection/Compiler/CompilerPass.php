<?php

namespace Lagdo\Symfony\Facades\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container): void
    {
        if(!$container->hasDefinition('lagdo.facades.service_locator'))
        {
            return;
        }

        $serviceLocator = $container->getDefinition('lagdo.facades.service_locator');
        // Append the tagged services to the service locator first argument.
        $locatedServices = $serviceLocator->getArguments()[0] ?? [];
        $services = $container->findTaggedServiceIds('lagdo.facades.service');
        foreach($services as $service => $_)
        {
            $locatedServices[$service] = new Reference($service);
        }
        $serviceLocator->replaceArgument(0, $locatedServices);
    }
}
