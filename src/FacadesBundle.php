<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FacadesBundle extends Bundle
{
    /**
     * @var Container
     */
    private static $facadeContainer = null;

    /**
     * @return Container
     */
    public static function getFacadeContainer(): Container
    {
        return self::$facadeContainer;
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        parent::boot();

        self::$facadeContainer = new Container($this->container);
    }
}
