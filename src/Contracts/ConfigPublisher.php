<?php namespace Esensi\Loaders\Contracts;

/**
 * Namespaced Config Publisher Interface
 *
 * @package Esensi\Publishers
 * @author daniel <daniel@emersonmedia.com>
 * @copyright 2015 Emerson Media LP
 * @license https://github.com/esensi/loaders/blob/master/LICENSE.txt MIT License
 * @link https://www.emersonmedia.com
 */
interface ConfigPublisher {

    /**
     * Publish the config files to a destination directory.
     * Optionally use a tag to distinguish these on the CLI.
     *
     * @param array|Symfony\Component\Finder\Finder $files
     * @param string $directories
     * @param string $tag (optional) to use for artisan vendor:publish
     * @return array
     */
    public function publishConfigsTo($files, $directory, $tag = 'config');

}
