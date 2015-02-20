<?php namespace Esensi\Loaders\Contracts;

/**
 * Namespaced Alias Loader Interface
 *
 * @package Esensi\Loaders
 * @author daniel <dalabarge@emersonmedia.com>
 * @copyright 2015 Emerson Media LP
 * @license https://github.com/esensi/loaders/blob/master/LICENSE.txt MIT License
 * @link https://www.emersonmedia.com
 */
interface AliasLoader {

    /**
     * Load the alias found in configs from a path under a namespace.
     *
     * @param string $path to look for config files
     * @param string $namespace to load aliases under
     * @param string $key (optional) within config file
     * @return void
     */
    public function loadAliasesFrom($path, $namespace, $key = 'aliases');

}
