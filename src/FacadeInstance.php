<?php

namespace Lagdo\Symfony\Facades;

trait FacadeInstance
{
    /**
     * The service instance.
     *
     * @var mixed
     */
    private static $_serviceInstance = null;

    /**
     * Get the service instance.
     * Overrides the default method, calls the container once, and saves the service instance locally.
     *
     * @return mixed
     */
    public static function instance()
    {
        return self::$_serviceInstance ?: self::$_serviceInstance = parent::instance();
    }
}
