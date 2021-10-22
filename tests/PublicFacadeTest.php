<?php

namespace Lagdo\Symfony\Facades\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Nyholm\BundleTest\AppKernel;
use Lagdo\Symfony\Facades\Container;

use Error;
use Exception;

class PublicFacadeTest extends KernelTestCase
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
            Facades\PrivateFacade::debug('Message');
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
            Facades\PublicFacade::debug('Message');
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
            Facades\PrivateFacade::debug('Message');
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
            Facades\PublicFacade::debug('Message');
            $error = false;
        }
        catch(Error $e){}
        catch(Exception $e){}
        $this->assertFalse($error);
    }
}
