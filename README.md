Facades for Symfony services
============================

With this package, Symfony services can be called using facades, with static method syntax.

It is a simpler alternative to passing services as parameters in the constructors of other classes.
It will be especially interesting in the case when a class depends on many services, but calls each of them only occasionally.

## Installation

Install the package with  `composer`.
```bash
composer require lagdo/symfony-facades
```

If the project is not using Symfony Flex, then add the `Lagdo\Symfony\Facades\FacadesBundle` in the `src/Kernel.php` file.

## Usage

A facade inherits from the `Lagdo\Symfony\Facades\AbstractFacade` abstract class, and implements the `getServiceId()` method, which returns the id of the corresponding service.

```php
namespace App\Facades;

use App\Services\MyService;
use Lagdo\Symfony\Facades\AbstractFacade;

class MyFacade extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceId()
    {
        return MyService::class;
    }
}
```

The methods of the service can now be called using the facade.

```php
use App\Facades\MyFacade;

MyFacade::myMethod();
```

## Using a service locator

The above facade will work only for services that are declared as public.

A service locator must be defined in the `config/services.yaml` file, in order to define facades for private services.
See the [Symfony service locators documentation](https://symfony.com/doc/4.4/service_container/service_subscribers_locators.html).

The following example defines a facade for the `Twig` service.

```yaml
    lagdo.service_locator:
        public: true
        class: Symfony\Component\DependencyInjection\ServiceLocator
        tags: ['container.service_locator']
        arguments:
            -
                Twig\Environment: '@twig'
```

With this definition, a facade can be defined for the service.

```php
namespace App\Facades;

use App\Services\MyService;
use Lagdo\Symfony\Facades\AbstractFacade;

class Twig extends AbstractFacade
{
    /**
     * @inheritdoc
     */
    protected static function getServiceId()
    {
        return 'Twig\Environment';
    }
}
```

The methods of the service can be called using the facade.

```php
use App\Facades\Twig;

$html = Twig::render($template, $vars);
```

Contribute
----------

- Issue Tracker: github.com/lagdo/symfony-facades/issues
- Source Code: github.com/lagdo/symfony-facades

License
-------

The package is licensed under the 3-Clause BSD license.
