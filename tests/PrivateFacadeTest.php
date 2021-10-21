<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Lagdo\Symfony\Facades\Container;

class PrivateFacadeTest extends KernelTestCase
{
    protected static function createKernel(array $options = [])
    {
        $env = 'test';
        return new FacadesKernel($env);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        // Get the real and unchanged service container
        // $container = self::$kernel->getContainer();

        Container::init(self::$kernel->getContainer());
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
        Facades\PrivateFacade::debug('Message');
        $this->assertTrue(true);
    }
}
