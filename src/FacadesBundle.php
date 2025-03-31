<?php

namespace Lagdo\Symfony\Facades;

use Lagdo\Facades\ContainerWrapper;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class FacadesBundle extends AbstractBundle
{
    /**
     * @inheritdoc
     */
    public function boot(): void
    {
        parent::boot();

        ContainerWrapper::setContainer(new Container($this->container));
    }

    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new DependencyInjection\Compiler\CompilerPass());
    }
}
