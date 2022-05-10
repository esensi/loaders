<?php namespace Esensi\Loaders\Providers;

use Esensi\Loaders\Providers\ServiceProvider;
use Esensi\Loaders\Contracts\YamlLoader as YamlLoaderContract;
use Esensi\Loaders\Traits\YamlLoader;

/**
 * Abtract service provider that makes use of the loader traits.
 * You can extend this service provider as a base for application services.
 *
 */
abstract class YamlServiceProvider extends ServiceProvider implements
    YamlLoaderContract {

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
        // Load configs files and publish them
        $path = __DIR__ . '/../../config';
        $this->loadYamlFrom($path, $this->namespace, $this->publish);

        // Load more configs and aliases
        parent::boot();
    }

}
