## Esensi Loaders Traits Package

> Version 2

An [Esensi\Loaders] package, coded by [SiteRocket Labs®](https://www.siterocket.com).

Esensi/Loaders uses [PHP traits](http://culttt.com/2014/06/25/php-traits) to supplement Laravel's missing namespaced config and alias loaders. Using traits allows for a high-degree of code reusability and extensibility. While this package provides a reasonable base service provider, developers are free to mix and match traits into any class that needs to make use of namespaced loaders. Using contracts, developers can be confident that the code complies to a reliable interface. (For more details on the inner workings of these traits please review the generously commented source code!)

## Note

This `Esensi/Activity` is specifically designed to be compatible with the [Laravel Framework](https://laravel.com) and may not be compatible as a stand-alone dependency or as part of another framework.

## Quick Start

Install the package with Composer: 

```bash
composer require esensi/loaders
```

Getting started with these new traits is a simple matter of extending the abstract `ServiceProvider` class that comes with the `Esensi/Loaders` package. This class already implements the two loader traits and is ready for quick customization. While the following example will get the job done, please consult the package's code for more customization options:

```php
<?php namespace App\Providers;

use Esensi\Loaders\Providers\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {

    /**
     * The namespace of the loaded config files.
     *
     * @var string
     */
    protected $namespace = 'vendor/package';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $namespace = $this->getNamespace();

        // Load the configs first
        $this->loadConfigsFrom(__DIR__ . '/../../config', $namespace, $this->publish);

        // Optionally use Laravel 8's methods for loading views and language files
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', $namespace);
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', $namespace);

        // Optionally load custom aliases out of the configs
        $this->loadAliasesFrom(config_path($namespace), $namespace);
    }

}
```

## Table of Contents

> **Help Write Better Documentation:** The documentation is still a work in progress. You can help others learn to reuse code by contributing better documentation as a pull request.

- **[Config Loader](#config-loader)**
- **[YAML Loader](#yaml-loader)**
- **[Alias Loader](#alias-loader)**
    - [Example Alias File](#example-alias-file)
- **[Unit Testing](#unit-testing)**
    - [Running the Unit Tests](#running-the-unit-tests)
- **[Contributing](#contributing)**
- **[Licensing](#licensing)**

## Config Loader

> **Pro Tip:** This package includes an abstract `ServiceProvider` that makes use of this trait. Package developers should consider extending the [`Esensi\Loaders\Providers\ServiceProvider`](https://github.com/esensi/loaders/blob/master/src/Providers/ServiceProvider.php) and customizing the `boot()` method.

The [`ConfigLoader`](https://github.com/esensi/loaders/blob/master/src/Traits/ConfigLoader.php) is a trait that package developers might find useful to provide the old Laravel 4 namespaced configs back to Laravel 8. With the move to Laravel 8, the internal config loader was simplified to make use of a single level deep config structure. This made it difficult for package developers to provide publishable configs that were easy to load and also did not conflict with other local configs. Suggestions for work arounds included prefixing the files (e.g.: `config('vendor-package.foo')`) or combining all of the config variables into a single file (e.g.: `config('vendor.package.foo')`). The Esensi development team was happy enough with the old way of it, so we decided to bring back the namespaced functionality (e.g.: `vendor/package::foo`) as a trait.

In order to provide the application with namespaced configs, simply use the `ConfigLoader` trait on any `ServiceProvider` class and call `loadConfigsFrom()` method from the `boot()` method of the class. By default this will make the configs found at the specified path available for publishing using `php artisan vendor:publish --tag="config"` (requires additional [`ConfigPublisher`](https://github.com/esensi/loaders/blob/master/src/Traits/ConfigPublisher.php) trait). The trait will then cascade the published configs on top of the package's original configs and set them in Laravel application's config repository.

```php
<?php namespace App\Providers;

use Esensi\Loaders\Contracts\ConfigLoader as ConfigLoaderContract;
use Esensi\Loaders\Traits\ConfigLoader;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider implements ConfigLoaderContract {

    /**
     * Load namespaced config files.
     *
     * @see Esensi\Loaders\Contracts\ConfigLoader
     */
    use ConfigLoader;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadConfigsFrom(__DIR__ . '/../../config', 'vendor/package');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
```

> **Pro Tip:** When used with [`ConfigPublisher`](https://github.com/esensi/loaders/blob/master/src/Traits/ConfigPublisher.php) trait, an optional third parameter of the `loadConfigsFrom()` method allows the package developer the option to turn on and off config publishing. An optional fourth parameter also allows for customization of the tag in which the configs will be published under. See the [`Esensi\Loaders\Contracts\ConfigLoader`](https://github.com/esensi/loaders/blob/master/src/Contracts/ConfigLoader.php) for more details.


## YAML Loader

> **Pro Tip:** This package includes an abstract `YamlServiceProvider` that makes use of this trait. Package developers should consider extending the [`Esensi\Loaders\Providers\YamlServiceProvider`](https://github.com/esensi/loaders/blob/master/src/Providers/YamlServiceProvider.php) and customizing the `boot()` method.

The [`YamlLoader`](https://github.com/esensi/loaders/blob/master/src/Traits/YamlLoader.php) is a trait that is very similar to the [`ConfigLoader`](https://github.com/esensi/loaders/blob/master/src/Traits/ConfigLoader.php) except that instead of parsing PHP config files it parses YAML config files. Package developers who prefer to use the YAML format for configuring their packages can use this trait to load all of their YAML config files in Laravel's config repository. Additionally it can be mixed with [`ConfigPublisher`](https://github.com/esensi/loaders/blob/master/src/Traits/ConfigPublisher.php) to make publishing of the package's YAML configs to the namespaced config path of the Laravel project.

In order to provide the application with namespaced YAML configs, simply use the `YamlLoader` trait on any `ServiceProvider` class and call `loadYamlFrom()` method from the `boot()` method of the class. By default this will make the YAML found at the specified path available for publishing using `php artisan vendor:publish --tag="yaml"` (requires additional [`ConfigPublisher`](https://github.com/esensi/loaders/blob/master/src/Traits/ConfigPublisher.php) trait). The trait will then cascade the published configs on top of the package's original configs and set them in Laravel 8's config repository. The new configs are then accessible via `config('vendor/package::foo')` just like they would have been in Laravel 4.

```php
<?php namespace App\Providers;

use Esensi\Loaders\Contracts\YamlLoader as YamlLoaderContract;
use Esensi\Loaders\Traits\YamlLoader;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider implements YamlLoaderContract {

    /**
     * Load namespaced YAML files.
     *
     * @see Esensi\Loaders\Contracts\YamlLoader
     */
    use YamlLoader;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadYamlFrom(__DIR__ . '/../../config', 'vendor/package');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
```

## Alias Loader

> **Pro Tip:** This package includes an abstract `ServiceProvider` that makes use of this trait. Package developers should consider extending the [`Esensi\Loaders\Providers\ServiceProvider`](https://github.com/esensi/loaders/blob/master/src/Providers/ServiceProvider.php) and customizing the `boot()` method.

The [`AliasLoader`](https://github.com/esensi/loaders/blob/master/src/Traits/AliasLoader.php) is a trait that package developers might find useful to bind Facades and other service locators or classes into the application's autoloader space. In a sense, this is what Laravel's Container does by type hinting interfaces in its dependency injection. When the interface is called for it's mapped or aliased to a concrete implementation. Using this trait does something similar but outside of the application's container and instead using PHP's native [`class_alias`](http://php.net/class_alias) method.

This trait allows for shortcuts to be made for any of the longer namespaced classes the package might use. It can also allow for developers to alias app namespaced classes (e.g.: `App\Foo\Bar`) that do not actually exist (or maybe don't yet exist) to vendor package classes (e.g.: `Foo\Bar\Class`) that actually do. Having the aliases stored in a config file allows for developers to quickly swap out the aliased classes with different instances. It also makes it easy to just drop the alias if the app namespaced class does exist: aliases are effectively placeholders.

In order to provide the application with these aliases, simply use the `AliasLoader` trait on any `ServiceProvider` class and call `loadAliasesFrom()` method from the `boot()` method of the class. By default this will scan the specified path for config files and map the aliases to the classes set on the `aliases` configuration line. These aliases are then available for use within other classes of the application.

```php
<?php namespace App\Providers;

use Esensi\Loaders\Contracts\AliasLoader as AliasLoaderContract;
use Esensi\Loaders\Traits\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider implements AliasLoaderContract {

    /**
     * Load namespaced aliases from the config files.
     *
     * @see Esensi\Loaders\Contracts\AliasLoader
     */
    use AliasLoader;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadAliasesFrom(config_path('vendor/package'), 'vendor/package');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
```

> **Pro Tip:** An optional third parameter of the `loadAliasesFrom()` method allows for customization of the key in which the `aliases` map should be found. See the [`Esensi\Loaders\Contracts\AliasLoader`](https://github.com/esensi/loaders/blob/master/src/Contracts/AliasLoader.php) for more details.

### Example Alias File

Just like the `config/app.php` file that comes with Laravel 8's default configurations, an `aliases` key should be added to any config file that should register aliases. Below is an example configuration file:

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application aliases
    |--------------------------------------------------------------------------
    |
    | The following configuration options allow the developer to map shortcut
    | and placeholder aliases to concrete classes. These aliases should be
    | loaded by a service provider that uses the AliasLoader trait. If
    | the app actually makes use of a class by the same name as an
    | alias then simply comment out the alias here so that the
    | real class may be used instead.
    |
    */
    'aliases' => [

        // A shortcut alias for a namespaced class
        'User' => 'App\Models\User',

        // A shortcut alias for a Facade or service locator
        'Foo' => 'Vendor\Package\FooFacade',

        // A placeholder alias for a missing class
        'App\Foo\Bar' => 'Vendor\Package\Foo\Bar',
    ]
];
```



## Unit Testing

_**Heads up!** This package doesn't have test coverage yet! These unit tests won't be hard to write, but we wanted to get this package out as soon as we could. They're on our TODO list! (Or, why wait? Get coverage even faster by sending us a pull request with tests. :wink:)_



## Contributing

Thank you for considering contributing to Esensi Core!



## Licensing

Copyright (c) 2022 [SiteRocket Labs](https://www.siterocket.com)

Esensi Core is open-sourced software licensed under the [MIT license](LICENSE.md).
