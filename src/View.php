<?php

namespace Lagdo\Symfony\Facades;

use Twig\Environment;

/**
 * @extends AbstractFacade<Environment>
 */
final class View extends AbstractFacade
{
    use ServiceInstance;

    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return Environment::class;
    }
}
