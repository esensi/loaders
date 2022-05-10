<?php namespace Esensi\Loaders\Traits;

use InvalidArgumentException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;

/**
 * Trait implementation of YamlLoader interface.
 *
 */
trait YamlLoader {

    /**
     * YAML Parser service.
     *
     * @var Symfony\Component\Yaml\Parser
     */
    protected $yaml;

    /**
     * Get the YAML parser service.
     *
     * @return Symfony\Component\Yaml\Parser
     */
    public function getYamlParser()
    {
        return $this->yaml ?: app('Symfony\Component\Yaml\Parser');
    }

    /**
     * Set the YAML parser service.
     *
     * @param  Symfony\Component\Yaml\Parser  $parser
     * @return void
     */
    public function setYamlParser(Parser $parser)
    {
        $this->yaml = $parser;
    }

    /**
     * Load the YAML from a path under a namespace.
     * Also optionally makes them available for publishing.
     *
     * @param  string  $path
     * @param  string  $namespace (optional)
     * @param  boolean  $publish (optional) YAML configs
     * @param  string  $tag (optional) to use for artisan vendor:publish
     * @return void
     */
    public function loadYamlFrom($path, $namespace = null, $publish = true, $tag = 'yaml')
    {
        // Wrapped in a try catch because Finder squawks when there is no directory
        try {

            // This directory is used both as the destination
            // for publishing configs and as the first path
            // the loader will look in for config files. The
            // loader will default back to the $path if files
            // cannot be found in this directory.
            $directory = config_path($namespace);

            // Get the local package files which can be published.
            // These should be loaded no matter if they are not published.
            $finder = Finder::create()->files()->name('*.yml')->name('*.yaml')->in($path);

            // Enable artisan vendor::publish command support.
            if ($publish) {
                if (! method_exists($this, 'publishConfigsTo')) {
                    throw new InvalidArgumentException('The publish argument is not usable without an implemented ConfigPublisher interface. Try using ConfigPublisher trait on the ' . $this::classname . ' class.');
                }

                // Get the YAML configs that need to be published
                $configs = $this->publishConfigsTo($finder, $directory, $tag);
            }

            // Append any published namespaced config files
            if ($publish && is_dir($directory)) {
                $files = Finder::create()->files()->name('*.yml')->name('*.yaml')->in($directory);
                $finder->append($files);
            }

            // Load each of the configs into the namespace
            foreach ($finder as $file) {
                // Get the key from the file name
                $key = snake_case(basename($file->getRealPath(), '.' . $file->getExtension()));
                $line = $namespace ? $namespace . '::' . $key : $key;

                // Get the YAML contents from the file
                $contents = $file->getContents();

                // Set the config with the loaded YAML config
                config()->set($line, $this->getYamlParser()->parse($contents));
            }

        // Silently ignore Finder exceptions
        } catch (InvalidArgumentException $e) {}
    }

}
