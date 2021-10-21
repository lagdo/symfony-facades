<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Nyholm\BundleTest\AppKernel;

use Lagdo\Symfony\Facades\AbstractFacade;

class PrivateFacadeTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return FacadesKernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();
        // Get the real and unchanged service container
        $container = self::$kernel->getContainer();

        AbstractFacade::setServiceContainer($container);
    }

    public function testService()
    {
        // Get the real and unchanged service container
        $container = self::$kernel->getContainer();

        // The logger service is private
        $this->assertFalse($container->has('logger'));
        // The facades service locator is public
        $this->assertTrue($container->has('lagdo.facades.service_locator'));
    }

    public function testFacade()
    {
        Facades\PrivateFacade::debug("Message\n");
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        // self::$kernel->shutdown();
        // self::$kernel = null;
    }
}
