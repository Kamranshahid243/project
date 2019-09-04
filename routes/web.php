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
        Route::get('shop-session/{id}', 'UserController@shopSession');

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

        //customers
        Route::resource('/customers', 'CustomerController');
        Route::post('/customers/bulk-edit', 'CustomerController@bulkEdit');
        Route::post('/customers/bulk-delete', 'CustomerController@bulkDelete');

        // Products
        Route::get('showProducts', "ProductsController@index");
        Route::post('addProduct', 'ProductsController@store');
        Route::delete('deleteProduct/{product_id}', "ProductsController@destroy");
        Route::resource('editProducts', "ProductsController");
        Route::post('/products/bulk-delete', "ProductsController@bulkDelete");
        Route::post('/products/bulk-edit', "ProductsController@bulkEdit");
        Route::get('statusCheck', "ProductsController@editStatus");
        Route::post('searchproduct', "ProductsController@search");

        //purchases
        Route::resource('purchases', 'PurchasesController');
        Route::post('/purchases/bulk-edit', 'PurchasesController@bulkEdit');
        Route::post('/purchases/bulk-delete', 'PurchasesController@bulkDelete');
        Route::get('get-vendors', 'PurchasesController@vendors');

        //orders
        Route::resource('/orders', 'OrdersController');
        Route::put('/updateOrders/{id}', 'OrdersController@updateCustomer');
        Route::post('/orders/bulk-edit', 'OrdersController@bulkEdit');
        Route::post('/orders/bulk-delete', 'OrdersController@bulkDelete');
        Route::get('add-orders', 'OrdersController@addOrder');
        Route::post('searchorder', 'OrdersController@SearchOrder');
        Route::put('editCustomer', 'OrdersController@update');
        Route::get('/reciept', 'OrdersController@openReciept');
        Route::get('showReciept', 'OrdersController@showReciept');

        // Bill Routes
        Route::resource('bills', 'BillController');
        Route::post('addOrder', 'BillController@store');
        Route::post('orderSearch', 'BillController@searchBill');

        //Vandors Routes
        Route::get('vendor', 'VendorController@index');
        Route::post('addVendor', 'VendorController@store');
        Route::resource('edit', 'VendorController');
        Route::delete('/deleteVendor/{vendor_id}', 'VendorController@destroy');
        Route::post('/vendors/bulk-edit', 'VendorController@bulkEdit');
        Route::post('/vendors/bulk-delete', 'VendorController@bulkDelete');
        Route::get('get-vendor-categories', 'VendorController@vendorCategories');
        //expenses
        Route::resource('expenses', 'ExpenseController');
        Route::post('/expenses/bulk-edit', 'ExpenseController@bulkEdit');
        Route::post('/expenses/bulk-delete', 'ExpenseController@bulkDelete');
        Route::get('get-shops', 'ShopController@allShops');
        Route::get('get-categories', 'ExpenseController@allExpenseCategories');

        //expense categories
        Route::resource('expense-category', 'ExpenseCategoryController');
        Route::post('/expense-category/bulk-edit', 'ExpenseCategoryController@bulkEdit');
        Route::post('/expense-category/bulk-delete', 'ExpenseCategoryController@bulkDelete');

        //vendor categories
        Route::resource('vendor-category', 'VendorCategoryController');
        Route::get('vendor-category-status', 'VendorCategoryController@updateStatus');
        Route::post('/vendor-category/bulk-edit', 'VendorCategoryController@bulkEdit');
        Route::post('/vendor-category/bulk-delete', 'VendorCategoryController@bulkDelete');

        //Product Category
        Route::resource('product-category', 'ProductCategoriesController');
        Route::post('changestatus', 'ProductCategoriesController@status');
        Route::get('shopid', 'ProductCategoriesController@getShopId');

        //income-expense reports
        Route::resource('income-expense', 'IncomeExpenseController');
        Route::post('show-report', 'IncomeExpenseController@incomeExpenseReport');

        //product summary reports
        Route::resource('product-summary', 'ProductSummaryController');
        Route::post('show-product-summary', 'ProductSummaryController@ProductSummaryReport');

//        income
        Route::resource('income', 'incomeController');
    });

    //sale chart
    Route::get('sale-chart', 'OrdersController@annualSale');
    Route::get('qty-chart', 'OrdersController@qtySale');
    Route::get('profit-chart', 'OrdersController@profitSale');

    //dashboard info boxes
    Route::get('top-seller', 'OrdersController@topSeller');


    if (env('APP_ENV') == 'local') {
        require_once __DIR__ . "/../tests/test-routes.php";
    }
});
