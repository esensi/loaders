<?php namespace Esensi\Loaders\Traits;

/**
 * Trait implementation of ConfigPublisher interface.
 *
 */
trait ConfigPublisher {

    /**
     * Publish the config files to a destination directory.
     * Optionally use a tag to distinguish these on the CLI.
     *
     * @param  array|Symfony\Component\Finder\Finder  $files
     * @param  string  $directories
     * @param  string  $tag (optional) to use for artisan vendor:publish
     * @return array
     */
    public function publishConfigsTo($files, $directory, $tag = 'config')
    {
        // Get the configs that need to be published
        $configs = [];
        foreach ($files as $file) {
            // Map the source to the destination
            // @example: vendor/package/config/foo.ext => config/vendor/package/foo.ext
            $configs[$file->getRealPath()] = $directory . '/' . basename($file->getRealPath());
        }

        // Publish the configs to the app config directory
        $this->publishes($configs, $tag);

        return $configs;
    }

}
