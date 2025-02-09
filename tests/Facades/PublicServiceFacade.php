<?php

namespace Lagdo\Symfony\Facades\Tests\Facades;

use Lagdo\Symfony\Facades\AbstractFacade;
use Lagdo\Symfony\Facades\Tests\Service\PublicServiceInterface;

/**
 * @extends AbstractFacade<PublicServiceInterface>
 */
class PublicServiceFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return PublicServiceInterface::class;
    }
}
