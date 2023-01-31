<?php

namespace Lagdo\Symfony\Facades\Tests\Facades;

use Lagdo\Symfony\Facades\AbstractFacade;
use Lagdo\Symfony\Facades\Tests\Service\PublicServiceInterface;

class PublicServiceFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier()
    {
        return PublicServiceInterface::class;
    }
}
