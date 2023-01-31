<?php

namespace Lagdo\Symfony\Facades\Tests\Facades;

use Lagdo\Symfony\Facades\AbstractFacade;
use Lagdo\Symfony\Facades\Tests\Service\PrivateServiceInterface;

class PrivateServiceFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier()
    {
        return PrivateServiceInterface::class;
    }
}
