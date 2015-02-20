<?php namespace Esensi\Loaders\Providers;

use Esensi\Loaders\Contracts\AliasLoader as AliasLoaderContract;
use Esensi\Loaders\Contracts\ConfigLoader as ConfigLoaderContract;
use Esensi\Loaders\Traits\AliasLoader;
use Esensi\Loaders\Traits\ConfigLoader;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Abtract service provider that makes use of the loader traits.
 * You can extend this service provider as a base for application services.
 *
 * @package Esensi\Loaders
 * @author daniel <dalabarge@emersonmedia.com>
 * @copyright 2014 Emerson Media LP
 * @license https://github.com/esensi/loaders/blob/master/LICENSE.txt MIT License
 * @link https://www.emersonmedia.com
 */
abstract class ServiceProvider extends BaseServiceProvider implements
    AliasLoaderContract,
    ConfigLoaderContract {

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
     * The namespace of the loaded config files.
     *
     * @var string
     */
    protected $namespace = 'esensi/loaders';

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
        $namespace = $this->getNamespace();

        // Load configs files and publish them
        $path = __DIR__ . '/../../config';
        $this->loadConfigsFrom($path, $namespace, $this->publish);

        // Load the aliases from the config files
        $path = config_path($namespace);
        $this->loadAliasesFrom($path, $namespace);
    }

    /**
     * Get the namespace that the loader will use.
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

}
