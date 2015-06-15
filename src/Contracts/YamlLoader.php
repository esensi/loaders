<?php namespace Esensi\Loaders\Contracts;

use  Symfony\Component\Yaml\Parser;

/**
 * Namespaced Yaml Loader Interface
 *
 * @package Esensi\Loaders
 * @author daniel <daniel@emersonmedia.com>
 * @copyright 2015 Emerson Media LP
 * @license https://github.com/esensi/loaders/blob/master/LICENSE.txt MIT License
 * @link https://www.emersonmedia.com
 */
interface YamlLoader {

    /**
     * Get the YAML parser service.
     *
     * @return Symfony\Component\Yaml\Parser
     */
    public function getYamlParser();

    /**
     * Set the YAML parser service.
     *
     * @param Symfony\Component\Yaml\Parser $parser
     * @return void
     */
    public function setYamlParser(Parser $parser);

    /**
     * Load the YAML from a path under a namespace.
     * Also optionally makes them available for publishing.
     *
     * @param string $path
     * @param string $namespace (optional)
     * @param boolean $publish (optional) YAML configs
     * @param string $tag (optional) to use for artisan vendor:publish
     * @return void
     */
    public function loadYamlFrom($path, $namespace = null, $publish = true, $tag = 'config');

}
