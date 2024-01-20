<?php

namespace Lagdo\Symfony\Facades\Tests\Facades\Instance;

use Lagdo\Symfony\Facades\FacadeInstance;
use Lagdo\Symfony\Facades\Tests\Service\PrivateServiceInterface;

class PrivateServiceFacade extends AbstractFacade
{
    use FacadeInstance;

    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier()
    {
        return PrivateServiceInterface::class;
    }
}
