<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Lagdo\Symfony\Facades\Container;
use Lagdo\Symfony\Facades\Log;
use Psr\Log\LoggerInterface;

use Error;
use Exception;

/**
 * Test the case where the service is private.
 * A service locator needs to be defined to give access to the service.
 */
class LoggerServiceTest extends KernelTestCase
{
    protected static function createKernel(array $options = [])
    {
        $env = 'test';
        return new Kernels\Kernel($env);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        // Get the real and unchanged service container.
        // $container = self::$kernel->getContainer();

        Container::init(self::$kernel->getContainer());
    }

    public function testService()
    {
        // Get the real and unchanged service container.
        $container = self::$kernel->getContainer();

        // The logger service is private.
        $this->assertFalse($container->has('logger'));
        // The facades service locator is public.
        $this->assertTrue($container->has('lagdo.facades.service_locator'));
        // The logger service is not defined.
        $this->assertFalse($container->has(LoggerInterface::class));
    }

    public function testLoggerFacade()
    {
        $error = true;
        try
        {
            Log::debug('Logger');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);
    }
}
