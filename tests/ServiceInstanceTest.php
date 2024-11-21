<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Lagdo\Symfony\Facades\FacadesBundle;
use Lagdo\Symfony\Facades\Tests\Facades\Instance\PublicServiceFacade;
use Lagdo\Symfony\Facades\Tests\Facades\Instance\PrivateServiceFacade;
use Lagdo\Symfony\Facades\Tests\Service\PublicServiceInterface;
use Lagdo\Symfony\Facades\Tests\Service\PrivateServiceInterface;
use Nyholm\BundleTest\TestKernel;

use function is_a;

/**
 * Test the ServiceInstance trait.
 * The service container must be called only once for each service.
 */
class ServiceInstanceTest extends KernelTestCase
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
        $kernel->addTestConfig(__DIR__ . '/config/locator.yaml');
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

        // The facades service locator present in the container.
        $this->assertTrue($container->has('lagdo.facades.service_locator'));
        // The public service can be read from the container.
        $this->assertTrue($container->has(PublicServiceInterface::class));
        // The private service cannot be read from the container.
        $this->assertFalse($container->has(PrivateServiceInterface::class));
    }

    public function testPrivateServiceFacade()
    {
        // Test the service class
        $this->assertTrue(is_a(PrivateServiceFacade::instance(), PrivateServiceInterface::class));

        // Test the service class
        $this->assertTrue(is_a(PublicServiceFacade::instance(), PublicServiceInterface::class));

        // The container is called once for each service
        $this->assertEquals(2, PrivateServiceFacade::$callCount);

        // Get the service one more time
        $this->assertTrue(is_a(PrivateServiceFacade::instance(), PrivateServiceInterface::class));
        // Get the service one more time
        $this->assertTrue(is_a(PublicServiceFacade::instance(), PublicServiceInterface::class));

        // The container was not called again
        $this->assertEquals(2, PrivateServiceFacade::$callCount);
    }
}
