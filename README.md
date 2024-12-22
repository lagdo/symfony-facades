[![Build Status](https://github.com/lagdo/symfony-facades/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/lagdo/symfony-facades/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lagdo/symfony-facades/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/lagdo/symfony-facades/?branch=main)
[![StyleCI](https://styleci.io/repos/418488513/shield?branch=main)](https://styleci.io/repos/418488513)
[![codecov](https://codecov.io/gh/lagdo/symfony-facades/branch/main/graph/badge.svg?token=HERKC60CC1)](https://codecov.io/gh/lagdo/symfony-facades)

[![Latest Stable Version](https://poser.pugx.org/lagdo/symfony-facades/v/stable)](https://packagist.org/packages/lagdo/symfony-facades)
[![Total Downloads](https://poser.pugx.org/lagdo/symfony-facades/downloads)](https://packagist.org/packages/lagdo/symfony-facades)
[![License](https://poser.pugx.org/lagdo/symfony-facades/license)](https://packagist.org/packages/lagdo/symfony-facades)

Facades for Symfony services
============================

With this package, Symfony services can be called using facades, with static method syntax.

It is a simpler alternative to passing services as parameters in the constructors of other classes, or using lazy services.
It will be especially interesting in the case when a class depends on many services, but calls some of them only occasionally.

### Installation

Install the package with  `composer`.
For Symfony version 6.* or older, install the version 2.3 of the package.
For Symfony version 7.*, install the version 3.0.

```bash
composer require lagdo/symfony-facades
```

Register the `Lagdo\Symfony\Facades\FacadesBundle` bundle in the `config/bundles.php` file.

### Usage

A facade inherits from the `Lagdo\Symfony\Facades\AbstractFacade` abstract class, and implements the `getServiceIdentifier()` method, which must return the id of the corresponding service in the Symfony service container.

```php
namespace App\Facades;

use App\Services\MyService;
use Lagdo\Symfony\Facades\AbstractFacade;

class MyFacade extends AbstractFacade
{
    /**
     * @inheritDoc
     */
    protected static function getServiceIdentifier(): string
    {
        return MyService::class;
    }
}
```

The methods of the `App\Services\MyService` service can now be called using the `App\Facades\MyFacade` facade, like this.

```php
class TheService
{
    public function theMethod()
    {
        MyFacade::myMethod();
    }
}
```

Instead of this.

```php
class TheService
{
    /**
     * @var MyService
     */
    protected $myService;

    public function __construct(MyService $myService)
    {
        $this->myService = $myService;
    }

    public function theMethod()
    {
        $this->myService->myMethod();
    }
}
```

### Using a service locator

The above facade will work only for services that are declared as public.

In order to call private services with facades, a service locator with id `lagdo.facades.service_locator` must be declared in the `config/services.yaml` file.
See the [Symfony service locators documentation](https://symfony.com/doc/4.4/service_container/service_subscribers_locators.html).

The private services that need to be accessed with a facade must be passed as arguments to the service locator.
For each argument, the key is the service id in the facade, while the value is the service id in the container.

In the following example, the `Twig` service is passed to the service locator.

```yaml
    lagdo.facades.service_locator:
        public: true
        class: Symfony\Component\DependencyInjection\ServiceLocator
        tags: ['container.service_locator']
        arguments:
            -
                Twig\Environment: '@twig'
```

A facade can then be defined for the `Twig` service.

```php
namespace App\Facades;

use Lagdo\Symfony\Facades\AbstractFacade;

class View extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return \Twig\Environment::class;
    }
}
```

Templates can now be rendered using the facade.

```php
use App\Facades\View;

class TheService
{
    public function theMethod()
    {
        ...
        $html = View::render($template, $vars);
        ...
    }
}
```

### The `lagdo.facades.service` tag

Starting from version 2.3.0, the private services that need to be accessed with a facade can be tagged with `lagdo.facades.service`.

These services will then be automatically passed to the service locator, together with those received as arguments.

In the following example, the `Twig` and `App\Services\TaggedService` services will be passed to the service locator.

```yaml
    lagdo.facades.service_locator:
        public: true
        class: Symfony\Component\DependencyInjection\ServiceLocator
        tags: ['container.service_locator']
        arguments:
            -
                Twig\Environment: '@twig'

    App\Services\TaggedService:
        tags: [lagdo.facades.service]
        class: App\Services\TaggedService
```

A facade can then be defined for the service.

```php
namespace App\Facades;

use App\Services\TaggedService;
use Lagdo\Symfony\Facades\AbstractFacade;

class TaggedServiceFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return TaggedService::class;
    }
}
```

### Getting the service instance

Starting from version 2.0.0, the `instance()` method returns the instance of the service.

```php
class TheService
{
    public function theMethod()
    {
        /**
         * @var MyService $service
         */
        $service = MyFacade::instance();
        $service->myMethod();
    }
}
```

### The `ServiceInstance` trait

By default, each call to a facade method will also call the Symfony service container.

Starting from version 2.2.0, the service instance can be saved in the facade after the first call to the Symfony service container, using the `ServiceInstance` trait.
The next calls with return the service instance without calling the Symfony service container.

```php
namespace App\Facades;

use App\Services\MyService;
use Lagdo\Symfony\Facades\AbstractFacade;
use Lagdo\Symfony\Facades\ServiceInstance;

class MyFacade extends AbstractFacade
{
    use ServiceInstance;

    /**
     * @inheritDoc
     */
    protected static function getServiceIdentifier(): string
    {
        return MyService::class;
    }
}
```

The Symfony service container is called only once in this example code.

```php
    MyFacade::myMethod1(); // Calls the Symfony service container
    MyFacade::myMethod2(); // Doesn't call the Symfony service container
    MyFacade::myMethod1(); // Doesn't call the Symfony service container
```

### Provided facades

This package includes facades for some Symfony services.

#### Logger

The `logger` service must be passed to the service locator in the `config/services.yaml` file.

```yaml
    lagdo.facades.service_locator:
        public: true
        class: Symfony\Component\DependencyInjection\ServiceLocator
        tags: ['container.service_locator']
        arguments:
            -
                Psr\Log\LoggerInterface: '@logger'
```

Messages can now be logged using the facade.

```php
use Lagdo\Symfony\Facades\Log;

Log::info($message, $vars);
```

#### View

The `twig` service must be passed to the service locator in the `config/services.yaml` file.

```yaml
    lagdo.facades.service_locator:
        public: true
        class: Symfony\Component\DependencyInjection\ServiceLocator
        tags: ['container.service_locator']
        arguments:
            -
                Twig\Environment: '@twig'
```

Views can now be rendered using the facade.

```php
use Lagdo\Symfony\Facades\View;

$html = View::render($template, $vars);
```

Contribute
----------

- Issue Tracker: github.com/lagdo/symfony-facades/issues
- Source Code: github.com/lagdo/symfony-facades

License
-------

The package is licensed under the 3-Clause BSD license.
