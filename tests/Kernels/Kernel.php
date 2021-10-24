<?php

namespace Lagdo\Symfony\Facades\Tests\Kernels;

use Symfony\Component\Config\Loader\LoaderInterface;
use Nyholm\BundleTest\AppKernel;

class Kernel extends AppKernel
{
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/services.yaml');
    }
}
