<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Nyholm\BundleTest\AppKernel;
use Lagdo\Symfony\Facades\Container;

class PublicFacadeTest extends KernelTestCase
{
    protected static function createKernel(array $options = [])
    {
        $env = 'test';
        return new AppKernel($env);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        // Get the container that allows fetching private services.
        // $container = self::getContainer();

        Container::init(self::getContainer());
    }

    public function testService()
    {
        $this->assertTrue(self::getContainer()->has('logger'));
    }

    public function testFacade()
    {
        // An exception is thrown in case of error.
        Facades\PublicFacade::debug('Message');
        $this->assertTrue(true);
    }
}
