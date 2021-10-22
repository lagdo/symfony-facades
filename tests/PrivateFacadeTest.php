<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Lagdo\Symfony\Facades\Container;

use Error;
use Exception;

class PrivateFacadeTest extends KernelTestCase
{
    protected static function createKernel(array $options = [])
    {
        $env = 'test';
        return new FacadesKernel($env);
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
            Facades\PrivateFacade::debug('Message');
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
            Facades\PublicFacade::debug('Message');
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
            Facades\PrivateFacade::debug('Message');
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
            Facades\PublicFacade::debug('Message');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertTrue($error);
    }
}
