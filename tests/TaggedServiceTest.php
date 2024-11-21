<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Lagdo\Symfony\Facades\FacadesBundle;
use Lagdo\Symfony\Facades\Log;
use Lagdo\Symfony\Facades\View;
use Lagdo\Symfony\Facades\Tests\Facades\TaggedServiceFacade;
use Lagdo\Symfony\Facades\Tests\Service\TaggedService;
use Lagdo\Symfony\Facades\Tests\Service\TaggedServiceInterface;
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
class TaggedServiceTest extends KernelTestCase
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
        $kernel->addTestConfig(__DIR__ . '/config/tagged-services.yaml');
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
        // The tagged service is private.
        $this->assertFalse($container->has(TaggedService::class));
        $this->assertFalse($container->has(TaggedServiceInterface::class));
    }

    public function testTaggedServiceFacade()
    {
        $serviceFound = false;
        try
        {
            TaggedServiceFacade::log('The logger facade works!');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);

        // Test the service class
        $this->assertTrue(is_a(TaggedServiceFacade::instance(), TaggedServiceInterface::class));
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

        // Test the service class
        $this->assertTrue(is_a(Log::instance(), LoggerInterface::class));
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
