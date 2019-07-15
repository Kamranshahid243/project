<?php

Route::group(['middleware' => ['web']], function () {
    Auth::routes();
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', function () {
            return view('dashboard.dashboard');
        });
        Route::get('/dashboard', function () {
            return view('dashboard.dashboard');
        });

        Route::get('/nvd-dashboard/load-config', 'NvdDashboardController@loadConfig');
        Route::post('/nvd-dashboard/save-config', 'NvdDashboardController@saveConfig');
        // nvd-crud routes go here

        // user
        Route::post('/user/change-password', 'UserController@changePassword');
        Route::get('/user/profile', 'UserController@profile');
        Route::resource('user', 'UserController');
        Route::post('/user/bulk-edit', 'UserController@bulkEdit');
        Route::post('/user/bulk-delete', 'UserController@bulkDelete');

        // user roles
        Route::resource('user-role', 'UserRoleController');
        Route::post('/user-role/bulk-edit', 'UserRoleController@bulkEdit');
        Route::post('/user-role/bulk-delete', 'UserRoleController@bulkDelete');
        Route::post('/user-role/save-actions', 'UserRoleController@saveRoleActions');
        Route::get('page', 'PageController@index');

        Route::get('load-menu', 'MenuController@load');

        Route::get('/online-users/load', 'OnlineUsersController@load');

        // shop
        Route::resource('shops', 'ShopController');
        Route::post('/shops/bulk-edit', 'ShopController@bulkEdit');
        Route::post('/shops/bulk-delete', 'ShopController@bulkDelete');
        Route::get('get-shops', 'ShopController@allShops');


        // Products
        Route::get('showProducts', "ProductsController@index");
        Route::post('addProduct', 'ProductsController@store');
        Route::delete('deleteProduct/{product_id}', "ProductsController@destroy");
        Route::resource('edit', "ProductsController");
    });

    if (env('APP_ENV') == 'local') {
        require_once __DIR__ . "/../tests/test-routes.php";
    }
});
