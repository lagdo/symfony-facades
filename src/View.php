<?php

namespace Lagdo\Symfony\Facades;

use Lagdo\Facades\AbstractFacade;
use Twig\Environment;

/**
 * @extends AbstractFacade<Environment>
 */
final class View extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return Environment::class;
    }
}
