<?php

use Admin\Http\Admin\Routes\AdminRoutes;

return [

    /*
     * The location of the changelog file.
     */

    'file' => base_path('CHANGELOG.md'),

    /*
     * You can tweak the route name and URL to your wishes. If
     * you need more cusomization, you can wrap it in a route
     * group or provide the route yourself.
     */

    'route' => [
        'name' => AdminRoutes::VIEW_CHANGELOG,
        'url' => 'updates',
    ],

    /*
     * The view that will show your changelog A default view is
     * provided, but it's best you use your own.
     */

    'view' => 'admin::pages/changelog',

    /*
     * By default, the changelog is loaded once and cached
     * indefinitely. On each deploy, you should clear the
     * cache to refresh the changelog.
     */

    'cache' => true,

    'cache_duration' => INF,

    'cache_key' => 'changelog',

];
