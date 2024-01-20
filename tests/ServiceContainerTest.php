<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Lagdo\Symfony\Facades\FacadesBundle;
use Lagdo\Symfony\Facades\Tests\Facades\PublicServiceFacade;
use Lagdo\Symfony\Facades\Tests\Facades\PrivateServiceFacade;
use Lagdo\Symfony\Facades\Tests\Service\PublicServiceInterface;
use Lagdo\Symfony\Facades\Tests\Service\PrivateServiceInterface;
use Nyholm\BundleTest\TestKernel;
use Error;
use Exception;

use function is_a;

/**
 * Test the case where the service can be fetched directly in the container.
 * The service locator is not defined.
 */
class ServiceContainerTest extends KernelTestCase
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
            '/config/services-pre62.yaml' : '/config/services.yaml'));
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

        // The facades service locator is not defined in the container.
        $this->assertFalse($container->has('lagdo.facades.service_locator'));
        // The public service can be read from the container.
        $this->assertTrue($container->has(PublicServiceInterface::class));
        // The private service cannot be read from the container.
        $this->assertFalse($container->has(PrivateServiceInterface::class));
    }

    public function testPrivateServiceFacade()
    {
        $serviceFound = false;
        try
        {
            PrivateServiceFacade::log('Container 01');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($serviceFound);

        $serviceFound = false;
        try
        {
            PublicServiceFacade::log('Container 02');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);

        $serviceFound = false;
        try
        {
            PrivateServiceFacade::log('Container 03');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($serviceFound);

        // Test the service class
        $this->assertTrue(is_a(PublicServiceFacade::instance(), PublicServiceInterface::class));

        // Test the service class
        $this->assertNull(PrivateServiceFacade::instance());
    }

    public function testPublicServiceFacade()
    {
        $serviceFound = false;
        try
        {
            PublicServiceFacade::log('Container 04');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);

        $serviceFound = false;
        try
        {
            PrivateServiceFacade::log('Container 05');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($serviceFound);

        $serviceFound = false;
        try
        {
            PublicServiceFacade::log('Container 06');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);

        // Test the service class
        $this->assertTrue(is_a(PublicServiceFacade::instance(), PublicServiceInterface::class));

        // Test the service class
        $this->assertNull(PrivateServiceFacade::instance());
    }
}
