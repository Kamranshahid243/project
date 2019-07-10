<?php

return [

    /*
     * Layout template used when generating views
     * */
    'layout' => 'layouts.app',
    /*
     * Views that will be generated. If you wish to add your own view,
     * make sure to create a template first in the
     * '/resources/views/crud-templates/views' directory.
     * */
    'views' => [
        'index',
        'ng-app',
    ],

    /*
     * Directory containing the templates
     * If you want to use your custom templates, specify them here
     * */
    'templates' => 'vendor.crud.ng-templates',

    /*
     * Routes file location
     * For laravel version < v5.3, use app/Http/routes.php
     * */
    'routes-file' => 'routes/web.php',

];