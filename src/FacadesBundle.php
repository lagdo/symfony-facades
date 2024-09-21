<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FacadesBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        parent::boot();

        Container::setContainer($this->container);
    }

    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DependencyInjection\Compiler\CompilerPass());
    }
}
