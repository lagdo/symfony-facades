<?php

namespace Lagdo\Symfony\Facades;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FacadesBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        parent::boot();

        AbstractFacade::setContainer($this->container);
    }
}
