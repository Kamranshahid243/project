<?php

namespace App\Http\Controllers;

use App\PageAction;

class MenuController extends Controller
{

    public function load()
    {
        $menu = $this->menu();
        $urls = $this->getUrls($menu);
        $allowedRoutes = array_merge($this->allowedRoutes($urls->toArray()), $this->commonRoutes());
        return $this->filterMenu($menu, $allowedRoutes);
    }

    private function getUrls($menu)
    {
        $urls = $menu->pluck('url')->filter(function ($value) {
            return $value != null;
        });

        $childMenus = $menu->pluck('child')->filter(function ($value) {
            return $value != null;
        });
        if ($childMenus->count()) {
            foreach ($childMenus as $option) {
                $urls = $urls->merge($this->getUrls($option));
            }
        }
        return $urls;
    }

    private function commonRoutes()
    {
        return [
            'dashboard',
            'logout',
        ];
    }

    private function allowedRoutes($routes)
    {
        $routes = PageAction::leftJoin('user_role_page_action', 'user_role_page_action.page_action_id', '=', 'page_actions.id')
            ->whereIn('route', $routes)
            ->where([
                ['user_role_id', '=', \Auth::user()->user_role_id],
                ['method', '=', 'GET']
            ])->get();
        return $routes->pluck('route')->toArray();
    }

    private function filterMenu($menu, $allowedMenu)
    {
        foreach ($menu as $key => $option) {
            if ($child = array_get($option, 'child')) {
                $option['child'] = $this->filterMenu($child, $allowedMenu);
                if (!$option['child']->count()) {
                    unset($menu[$key]);
                    continue;
                }
                $menu[$key] = $option;
                continue;
            }
            $url = array_get($option, 'url');
            if (!in_array($url, $allowedMenu)) {
                unset($menu[$key]);
            }
        }
        return $menu->values();
    }

    private function menu()
    {
        $array = [
            [
                'url' => 'dashboard',
                'class' => 'fa fa-tachometer-alt',
                'title' => 'Dashboard'
            ],
            [
                'class' => 'fas fa-database',
                'title' => 'Data',
                'child' => $this->data()
            ],
            [
                'class' => 'fa fa-list-alt',
                'title' => 'Categories',
                'child' => $this->categories(),
            ],
            [
                'class' => 'fas fa-chart-line',
                'title' => 'Reports',
                'child' => $this->manageReports()
            ],

            [
                'class' => 'fa fa-cogs',
                'title' => 'System',
                'child' => $this->system()
            ],
            [
                'url' => 'logout',
                'class' => 'fa fa-sign-out-alt',
                'title' => 'Logout',
                'attributes' => [
                    [
                        'attribute' => "onclick",
                        'value' => "event.preventDefault();document.getElementById('logout-form').submit();",
                    ]
                ]
            ],
        ];
        return collect($array);
    }

    private function data()
    {
        $array = [
            [
                'url' => 'shops',
                'class' => 'fas fa-store',
                'title' => 'Shops'
            ],
            [
                'url' => 'showProducts',
                'class' => 'fab fa-product-hunt',
                'title' => 'Products',
            ],
            [
                'url' => 'customers',
                'class' => 'fas fa-store',
                'title' => 'Customers'
            ],
            [
                'url' => 'purchases',
                'class' => 'fas fa-shopping-cart',
                'title' => 'Purchases',
            ],
            [
                'class' => 'fas fa-coins',
                'title' => 'Expenses',
                'url' => 'expenses',
            ],
            [
                'url' => 'orders',
                'class' => 'fas fa-shopping-cart',
                'title' => 'Orders',
            ],
            [
                'url' => 'vendor',
                'class' => 'fas fa-truck-moving',
                'title' => 'Vendors',
            ],

        ];
        return collect($array);
    }

    private function system()
    {
        $array = [
            [
                'url' => 'user',
                'class' => 'fa fa-users',
                'title' => 'Users'
            ],
            [
                'url' => 'user-role',
                'class' => 'fa fa-universal-access',
                'title' => 'User Roles Management'
            ],
        ];
        return collect($array);
    }

    private function manageReports()
    {
        $array = [
            [
                'url' => 'income-expense',
                'class' => 'fas fa-coins',
                'title' => 'Income-Expense Report'
            ],
            [
                'url' => 'product-summary',
                'class' => 'fab fa-product-hunt',
                'title' => 'Product Summary Report'
            ],
            [
                'url' => 'vendor-report',
                'class' => 'fas fa-truck-moving',
                'title' => 'Vendor Stock Report'
            ],
        ];
        return collect($array);
    }

    private function categories()
    {
        $array = [
            [
                'url' => 'vendor-category',
                'class' => 'fas fa-truck-moving',
                'title' => 'Vendor Categories'
            ],
            [
                'url' => 'product-category',
                'class' => 'fab fa-product-hunt',
                'title' => 'Product Categories'
            ],
            [
                'url' => 'expense-category',
                'class' => 'fa fa-universal-access',
                'title' => 'Expense Categories'
            ],
        ];
        return collect($array);
    }
}
