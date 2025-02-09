<?php

namespace Lagdo\Symfony\Facades\Tests\Facades;

use Lagdo\Symfony\Facades\AbstractFacade;
use Lagdo\Symfony\Facades\Tests\Service\TaggedService;

/**
 * @extends AbstractFacade<TaggedService>
 */
class TaggedServiceFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return TaggedService::class;
    }
}
