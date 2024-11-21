<?php

namespace Lagdo\Symfony\Facades\Tests\Facades\Instance;

abstract class AbstractFacade extends \Lagdo\Symfony\Facades\AbstractFacade
{
    public static $callCount = 0;

    /**
     * Get the service instance, and increment the call counter.
     *
     * @return mixed
     */
    public static function instance(): mixed
    {
        self::$callCount++;
        return parent::instance();
    }
}
