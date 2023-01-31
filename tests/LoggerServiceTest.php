<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Lagdo\Symfony\Facades\Container;
use Lagdo\Symfony\Facades\FacadesBundle;
use Lagdo\Symfony\Facades\Log;
use Nyholm\BundleTest\TestKernel;
use Psr\Log\LoggerInterface;

use Error;
use Exception;

/**
 * Test the case where the service is private.
 * A service locator needs to be defined to give access to the service.
 */
class LoggerServiceTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var TestKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(FacadesBundle::class);
        $kernel->addTestConfig(__DIR__ . '/config/logger.yaml');
        $kernel->handleOptions($options);

        return $kernel;
    }

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testService()
    {
        // Get the real and unchanged service container.
        $container = self::$kernel->getContainer();

        // The facades service locator is public.
        $this->assertTrue($container->has('lagdo.facades.service_locator'));
        // The logger service is private.
        $this->assertFalse($container->has('logger'));
        $this->assertFalse($container->has(LoggerInterface::class));
    }

    public function testLoggerFacade()
    {
        $serviceFound = false;
        try
        {
            Log::debug('The logger facade works!');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);
    }
}
