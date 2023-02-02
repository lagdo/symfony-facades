<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FacadesBundle extends Bundle
{
    /**
     * @var Container
     */
    private static $serviceContainer = null;

    /**
     * @param string $serviceId
     *
     * @return mixed|null
     */
    public static function getFacadeService(string $serviceId)
    {
        return self::$serviceContainer->getService($serviceId);
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        parent::boot();

        self::$serviceContainer = new Container($this->container);
    }
}
