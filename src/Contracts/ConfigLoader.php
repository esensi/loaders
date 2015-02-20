<?php namespace Esensi\Loaders\Contracts;

/**
 * Namespaced Config Loader Interface
 *
 * @package Esensi\Loaders
 * @author daniel <dalabarge@emersonmedia.com>
 * @copyright 2015 Emerson Media LP
 * @license https://github.com/esensi/loaders/blob/master/LICENSE.txt MIT License
 * @link http://www.emersonmedia.com
 */
interface ConfigLoader {

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
    public function loadConfigsFrom($path, $namespace, $publish = true, $tag = 'config');

}
