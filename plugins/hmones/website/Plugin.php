<?php namespace Hmones\Website;

use Backend;
use System\Classes\PluginBase;
use Hmones\Website\Models\Topic;

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

        \Event::listen('offline.sitesearch.query', function ($query) {

            // The controller is used to generate page URLs.
            $controller = \Cms\Classes\Controller::getController() ?? new \Cms\Classes\Controller();

            // Search your plugin's contents
            $items = Topic::where('title', 'like', "%${query}%")->orWhere('content', 'like', "%${query}%")->get();

            // Now build a results array
            $results = $items->map(function ($item) use ($query, $controller) {

                // If the query is found in the title, set a relevance of 2
                $relevance = mb_stripos($item->title, $query) !== false ? 2 : 1;
                
                // Optional: Add an age penalty to older results. This makes sure that
                // newer results are listed first.
                // if ($relevance > 1 && $item->created_at) {
                //    $ageInDays = $item->created_at->diffInDays(\Illuminate\Support\Carbon::now());
                //    $relevance -= \OFFLINE\SiteSearch\Classes\Providers\ResultsProvider::agePenaltyForDays($ageInDays);
                // }

                return [
                    'title'     => $item->title,
                    'text'      => $item->content,
                    'url'       => $controller->pageUrl('topic', ['slug' => $item->slug]),
                    // 'thumb'     => optional($item->image)->first(), // Instance of System\Models\File
                    'relevance' => $relevance, // higher relevance results in a higher
                                            // position in the results listing
                    // 'meta' => 'data',       // optional, any other information you want
                                            // to associate with this result
                    // 'model' => $item,       // optional, pass along the original model
                ];
            });

            return [
                'provider' => 'Topic', // The badge to display for this result
                'results'  => $results,
            ];
        });
    
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
