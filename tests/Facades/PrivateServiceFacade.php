<?php

namespace Lagdo\Symfony\Facades\Tests\Facades;

use Lagdo\Facades\AbstractFacade;
use Lagdo\Symfony\Facades\Tests\Service\PrivateServiceInterface;

/**
 * @extends AbstractFacade<PrivateServiceInterface>
 */
class PrivateServiceFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return PrivateServiceInterface::class;
    }
}
