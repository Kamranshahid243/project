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
                'url' => 'shops',
                'class' => 'fas fa-store',
                'title' => 'Shops'
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
}
