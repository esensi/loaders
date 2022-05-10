<?php namespace Esensi\Loaders\Providers;

use Esensi\Loaders\Contracts\AliasLoader as AliasLoaderContract;
use Esensi\Loaders\Contracts\ConfigLoader as ConfigLoaderContract;
use Esensi\Loaders\Contracts\ConfigPublisher as ConfigPublisherContract;
use Esensi\Loaders\Traits\AliasLoader;
use Esensi\Loaders\Traits\ConfigLoader;
use Esensi\Loaders\Traits\ConfigPublisher;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Abtract service provider that makes use of the loader traits.
 * You can extend this service provider as a base for application services.
 *
 */
abstract class ServiceProvider extends BaseServiceProvider implements
    AliasLoaderContract,
    ConfigLoaderContract,
    ConfigPublisherContract {

    /**
     * Load namespaced aliases from the config files.
     *
     * @see Esensi\Loaders\Contracts\AliasLoader
     */
    use AliasLoader;

    /**
     * Load namespaced config files.
     *
     * @see Esensi\Loaders\Contracts\ConfigLoader
     */
    use ConfigLoader;

    /**
     * Publish namespaced config files.
     *
     * @see Esensi\Loaders\Contracts\ConfigPublisher
     */
    use ConfigPublisher;

    /**
     * The namespace of the loaded config files.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * Whether to publish the configs or not.
     *
     * @var boolean
     */
    protected $publish = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Load configs from files
        $path = __DIR__ . '/../../config';
        $this->loadConfigsFrom($path, $this->namespace, $this->publish);

        // Load the aliases from the config
        $path = config_path($this->namespace);
        $this->loadAliasesFrom($path, $this->namespace);
    }

    /**
     * Register any application services.
     * This is provided here so we don't have to redeclare
     * and empty one on a parent class if it is not needed.
     *
     * @return void
     */
    public function register()
    {

    }

}
