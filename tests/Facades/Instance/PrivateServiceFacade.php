<?php

namespace Lagdo\Symfony\Facades\Tests\Facades\Instance;

use Lagdo\Facades\ServiceInstance;
use Lagdo\Symfony\Facades\Tests\Service\PrivateServiceInterface;

/**
 * @extends AbstractFacade<PrivateServiceInterface>
 */
class PrivateServiceFacade extends AbstractFacade
{
    use ServiceInstance;

    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return PrivateServiceInterface::class;
    }
}
