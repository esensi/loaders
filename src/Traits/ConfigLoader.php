<?php namespace Esensi\Loaders\Traits;

use InvalidArgumentException;
use Symfony\Component\Finder\Finder;

/**
 * Trait implementation of ConfigLoader interface.
 *
 * @package Esensi\Loaders
 * @author daniel <dalabarge@emersonmedia.com>
 * @copyright 2015 Emerson Media LP
 * @license https://github.com/esensi/loaders/blob/master/LICENSE.txt MIT License
 * @link http://www.emersonmedia.com
 * @see Esensi\Loaders\Contracts\ConfigLoader
 */
trait ConfigLoader {

    /**
     * Load the configs from a path under a namespace.
     * Also optionally makes them available for publishing.
     *
     * @param string $path
     * @param string $namespace
     * @param boolean $publish (optional) configs
     * @param string $tag (optional) to use for artisan vendor:publish
     * @return void
     */
    public function loadConfigsFrom($path, $namespace, $publish = true, $tag = 'config')
    {
        // This directory is used both as the destination
        // for publishing configs and as the first path
        // the loader will look in for config files. The
        // loader will default back to the $path if files
        // cannot be found in this directory.
        $directory = config_path($namespace);

        // Enable artisan vendor::publish command support.
        if( $publish )
        {
            // Get the configs that need to be published
            $configs = [];
            $files = Finder::create()->files()->name('*.php')->in($path);
            foreach($files as $file)
            {
                // Map the source to the destination
                // @example: vendor/package/config/foo.php => config/vendor/package/foo.php
                $configs[$file->getRealPath()] = $directory . '/' . basename($file->getRealPath());
            }

            // Publish the configs to the app config directory
            $this->publishes($configs, $tag);
        }

        // Wrapped in a try catch because Finder squawks when there is no directory
        try{

            // Load the namespaced config files merging the
            // published configs with the vendor configs
            $files = Finder::create()->files()->name('*.php')->in($directory);
            $files = $publish ? array_merge(array_keys($configs), $files) : $files;
            foreach($files as $file)
            {
                $filename = basename($file->getRealPath(), '.php');
                $line = $namespace . '::' . $filename;
                config([$line, require $file->getRealPath()]);
            }

        // Silently ignore Finder exceptions
        } catch( InvalidArgumentException $e){}
    }

}
