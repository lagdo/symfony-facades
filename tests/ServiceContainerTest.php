<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Nyholm\BundleTest\AppKernel;
use Lagdo\Symfony\Facades\Container;
use Lagdo\Symfony\Facades\Tests\Facades\PublicFacade;
use Lagdo\Symfony\Facades\Tests\Facades\PrivateFacade;

use Error;
use Exception;

/**
 * Test the case where the service can be fetched directly in the container.
 * The service locator is not defined.
 */
class ServiceContainerTest extends KernelTestCase
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
        // Get the container that allows fetching private services.
        $container = self::getContainer();

        // The logger service is can be fetched.
        $this->assertTrue($container->has('logger'));
        // The facades service locator is not defined.
        $this->assertFalse($container->has('lagdo.facades.service_locator'));
        // The custom service is not defined.
        $this->assertFalse($container->has('lagdo.facades.test_service'));
    }

    public function testPrivateFacade()
    {
        $error = true;
        try
        {
            PrivateFacade::debug('Container 01');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PublicFacade::debug('Container 02');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Container 03');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);
    }

    public function testPublicFacade()
    {
        $error = true;
        try
        {
            PublicFacade::debug('Container 04');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Container 05');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PublicFacade::debug('Container 06');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);
    }

    public function testPrivateFacadeAgain()
    {
        $error = true;
        try
        {
            PrivateFacade::debug('Container 07');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PublicFacade::debug('Container 08');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Container 08');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);
    }

    public function testPublicFacadeAgain()
    {
        $error = true;
        try
        {
            PublicFacade::debug('Container 10');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Container 11');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PublicFacade::debug('Container 12');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);
    }
}
