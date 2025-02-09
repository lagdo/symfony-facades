<?php

namespace Lagdo\Symfony\Facades;

use Psr\Log\LoggerInterface;

/**
 * @extends AbstractFacade<LoggerInterface>
 */
final class Log extends AbstractFacade
{
    use ServiceInstance;

    /**
     * @inheritDoc
     */
    protected static function getServiceIdentifier(): string
    {
        return LoggerInterface::class;
    }
}
