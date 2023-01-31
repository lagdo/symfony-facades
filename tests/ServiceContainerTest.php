<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Lagdo\Symfony\Facades\Container;
use Lagdo\Symfony\Facades\FacadesBundle;
use Lagdo\Symfony\Facades\Tests\Facades\PublicServiceFacade;
use Lagdo\Symfony\Facades\Tests\Facades\PrivateServiceFacade;
use Lagdo\Symfony\Facades\Tests\Service\PublicServiceInterface;
use Lagdo\Symfony\Facades\Tests\Service\PrivateServiceInterface;
use Nyholm\BundleTest\TestKernel;

use Error;
use Exception;

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
        $kernel->addTestConfig(__DIR__ . '/config/services.yaml');
        $kernel->handleOptions($options);

        return $kernel;
    }

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testService()
    {
        // Get the container that allows fetching private services.
        $container = self::getContainer();

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
    }

    public function testPrivateServiceFacadeAgain()
    {
        $serviceFound = false;
        try
        {
            PrivateServiceFacade::log('Container 07');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($serviceFound);

        $serviceFound = false;
        try
        {
            PublicServiceFacade::log('Container 08');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);

        $serviceFound = false;
        try
        {
            PrivateServiceFacade::log('Container 08');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($serviceFound);
    }

    public function testPublicServiceFacadeAgain()
    {
        $serviceFound = false;
        try
        {
            PublicServiceFacade::log('Container 10');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);

        $serviceFound = false;
        try
        {
            PrivateServiceFacade::log('Container 11');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($serviceFound);

        $serviceFound = false;
        try
        {
            PublicServiceFacade::log('Container 12');
            $serviceFound = true;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($serviceFound);
    }
}
