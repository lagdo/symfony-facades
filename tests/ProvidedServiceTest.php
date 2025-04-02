<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Lagdo\Facades\Logger;
use Lagdo\Symfony\Facades\Container;
use Lagdo\Symfony\Facades\FacadesBundle;
use Lagdo\Symfony\Facades\View;
use Nyholm\BundleTest\TestKernel;
use Psr\Log\LoggerInterface;
use Twig\Environment as TemplateEngine;
use Error;
use Exception;

use function is_a;

/**
 * Test the case where the service is private.
 * A service locator needs to be defined to give access to the service.
 */
class ProvidedServiceTest extends KernelTestCase
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
        $kernel->addTestConfig(__DIR__ . (TestKernel::VERSION_ID < 60200 ?
            '/config/included-pre62.yaml' : '/config/included.yaml'));
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
        // The view service is private.
        $this->assertFalse($container->has(TemplateEngine::class));
    }

    public function testPsrContainer()
    {
        // Create a PSR-11 container.
        $container = new Container(self::$kernel->getContainer());

        $this->assertTrue($container->has(LoggerInterface::class));
        $this->assertTrue($container->has(TemplateEngine::class));
    }

    public function testLoggerFacade()
    {
        $serviceFound = false;
        try
        {
            Logger::debug('The logger facade works!');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);

        // Test the service class
        $this->assertTrue(is_a(Logger::instance(), LoggerInterface::class));
    }

    public function testViewFacade()
    {
        $charset = false;
        try
        {
            $charset = View::getCharset();
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertIsString($charset);
        $this->assertEquals($charset, 'UTF-8');

        // Test the service class
        $this->assertTrue(is_a(View::instance(), TemplateEngine::class));
    }
}
