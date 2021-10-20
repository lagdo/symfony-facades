Facades for Symfony services
============================

With this package, Symfony services can be called using facades, with static method syntax.

It is a simpler alternative to passing services as parameters in the constructors of other classes, or using lazy services.
It will be especially interesting in the case when a class depends on many services, but calls each of them only occasionally.

## Installation

Install the package with  `composer`.
```bash
composer require lagdo/symfony-facades
```

If the project is not using Symfony Flex, then register the `Lagdo\Symfony\Facades\FacadesBundle` bundle in the `src/Kernel.php` file.

## Usage

A facade inherits from the `Lagdo\Symfony\Facades\AbstractFacade` abstract class, and implements the `getServiceIdentifier()` method, which returns the id of the corresponding service.

```php
namespace App\Facades;

use App\Services\MyService;
use Lagdo\Symfony\Facades\AbstractFacade;

class MyFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier()
    {
        return MyService::class;
    }
}
```

The methods of the `App\Services\MyService` service can now be called using the facade.

```php
use App\Facades\MyFacade;

MyFacade::myMethod();
```

## Using a service locator

The above facade will work only for services that are declared as public.

A service locator must be declared in the `config/services.yaml` file, in order to create facades for private services.
See the [Symfony service locators documentation](https://symfony.com/doc/4.4/service_container/service_subscribers_locators.html).

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

use Twig\Environment;
use Lagdo\Symfony\Facades\AbstractFacade;

class Twig extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier()
    {
        return Environment::class;
    }
}
```

Templates can now be rendered using the facade.

```php
use App\Facades\Twig;

$html = Twig::render($template, $vars);
```

## Provided facades

This package provides facades for some Symfony services.

#### Logger

The logger service must be passed to the service locator in the `config/services.yaml` file.

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

Contribute
----------

- Issue Tracker: github.com/lagdo/symfony-facades/issues
- Source Code: github.com/lagdo/symfony-facades

License
-------

The package is licensed under the 3-Clause BSD license.
