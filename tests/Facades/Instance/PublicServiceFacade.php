<?php

namespace Lagdo\Symfony\Facades\Tests\Facades\Instance;

use Lagdo\Symfony\Facades\ServiceInstance;
use Lagdo\Symfony\Facades\Tests\Service\PublicServiceInterface;

/**
 * @extends AbstractFacade<PublicServiceInterface>
 */
class PublicServiceFacade extends AbstractFacade
{
    use ServiceInstance;

    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return PublicServiceInterface::class;
    }
}
