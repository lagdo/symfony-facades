<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Nyholm\BundleTest\AppKernel;
use Lagdo\Symfony\Facades\FacadesBundle;

class FacadesKernel extends AppKernel
{
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/services.yaml');
    }
}
