<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Lagdo\Symfony\Facades\Container;
use Lagdo\Symfony\Facades\Tests\Facades\PublicFacade;
use Lagdo\Symfony\Facades\Tests\Facades\PrivateFacade;

use Error;
use Exception;

/**
 * Test the case where the service is private.
 * A service locator needs to be defined to give access to the service.
 */
class ServiceLocatorTest extends KernelTestCase
{
    protected static function createKernel(array $options = [])
    {
        $env = 'test';
        return new Kernels\LocatorKernel($env);
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
        // The custom service is not defined.
        $this->assertFalse($container->has('lagdo.facades.test_service'));
    }

    public function testPrivateFacade()
    {
        $error = true;
        try
        {
            PrivateFacade::debug('Locator 01');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PublicFacade::debug('Locator 02');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Locator 03');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);
    }

    public function testPublicFacade()
    {
        $error = true;
        try
        {
            PublicFacade::debug('Locator 04');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Locator 05');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PublicFacade::debug('Locator 06');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);
    }

    public function testPrivateFacadeAgain()
    {
        $error = true;
        try
        {
            PrivateFacade::debug('Locator 07');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PublicFacade::debug('Locator 08');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Locator 09');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);
    }

    public function testPublicFacadeAgain()
    {
        $error = true;
        try
        {
            PublicFacade::debug('Locator 10');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);

        $error = true;
        try
        {
            PrivateFacade::debug('Locator 11');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);

        $error = true;
        try
        {
            PublicFacade::debug('Locator 12');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);
    }
}
