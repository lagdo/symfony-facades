<?php

namespace Lagdo\Symfony\Facades\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

use function array_keys;

class CompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition('lagdo.facades.service_locator'))
        {
            return;
        }

        $serviceLocatorDefinition = $container->getDefinition('lagdo.facades.service_locator');

        // Append the tagged services to the service locator first argument.
        $locatedServices = $serviceLocatorDefinition->getArguments()[0] ?? [];
        $services = $container->findTaggedServiceIds('lagdo.facades.service');
        foreach(array_keys($services) as $service)
        {
            $locatedServices[$service] = new Reference($service);
        }

        $serviceLocatorDefinition->replaceArgument(0, $locatedServices);
    }
}
