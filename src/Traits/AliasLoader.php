<?php namespace Esensi\Loaders\Traits;

use Illuminate\Foundation\AliasLoader as Loader;
use InvalidArgumentException;
use Symfony\Component\Finder\Finder;

/**
 * Trait implementation of AliasLoader interface.
 *
 * @package Esensi\Loaders
 * @author daniel <dalabarge@emersonmedia.com>
 * @copyright 2015 Emerson Media LP
 * @license https://github.com/esensi/loaders/blob/master/LICENSE.txt MIT License
 * @link https://www.emersonmedia.com
 * @see Esensi\Loaders\Contracts\AliasLoader
 */
trait AliasLoader {

    /**
     * Load the alias found in configs from a path under a namespace.
     *
     * @param string $path to look for config files
     * @param string $namespace to load aliases under
     * @param string $key (optional) within config file
     * @return void
     */
    public function loadAliasesFrom($path, $namespace, $key = 'aliases')
    {
        // Get the alias loader
        $loader = Loader::getInstance();

        // Prepare key for config line
        $key = ! is_null($key) ? '.' . $key : null;

        // Wrapped in a try catch because Finder squawks when there is no directory
        try{

            // Load the namespaced config files
            $files = Finder::create()->files()->name('*.php')->in($path);
            foreach($files as $file)
            {
                // Construct the config line where aliases are defined
                $filename = basename($file->getRealPath(), '.php');;
                $line = $namespace . '::' . $filename . $key;

                // Load each of the aliases
                $aliases = config($line, []);
                foreach( $aliases as $alias => $class)
                {
                    $loader->alias($alias, $class);
                }
            }

        // Silently ignore Finder exceptions
        } catch( InvalidArgumentException $e){}
    }

}
