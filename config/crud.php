<?php

return [

    /*
     * Layout template used when generating views
     * */
    'layout' => 'layouts.master',
    
    /*
     * Views that will be generated. If you wish to add your own view,
     * make sure to create a template first in the
     * '/resources/views/crud-templates/views' directory.
     * */
    'views' => [
        'index',
        'create',
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

    /*
     * Extra routes, other than the 'Route::resource('{{route}}', '{{controller}}');
     * e.g. Route::post('/{{route}}/bulk-delete', '{{controller}}@bulkDelete');
     * */
    'extra-routes' => [
        "Route::post('/{{route}}/bulk-delete', '{{controller}}@bulkDelete');",
        "Route::post('/{{route}}/bulk-edit', '{{controller}}@bulkEdit');"
    ],

    /*
     * Fields that should be skipped on the listing page
     * */
    'skipped-fields' => ['id', 'created_at', 'updated_at', 'password', 'token', 'remember_token'],

];