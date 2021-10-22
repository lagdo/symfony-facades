<?php

namespace Lagdo\Symfony\Facades\Tests\Facades;

use Lagdo\Symfony\Facades\AbstractFacade;

class PrivateFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier()
    {
        return 'lagdo.facades.test_service';
    }
}
