<?php namespace Hmones\Website;

use Backend;
use System\Classes\PluginBase;

/**
 * website Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'website',
            'description' => 'Plugin for the display options for the main public website',
            'author'      => 'hmones',
            'icon'        => 'icon-desktop'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Hmones\Website\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'hmones.website.some_permission' => [
                'tab' => 'website',
                'label' => 'Some permission'
            ],
        ];
    }
}
