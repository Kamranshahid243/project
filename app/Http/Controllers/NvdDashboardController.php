<?php

namespace App\Http\Controllers;

use App\Widget;

class NvdDashboardController extends Controller
{
    public function loadConfig()
    {
        // get config from user_dashboard_settings table
        $config = \Auth::user()->dashboardSettings();
        // if not found, get default config
        if (!$config) {
            $config = $this->defaultConfig();
        }
        $widgets = Widget::enabled()->keyBy('id');
        $allowedWidgetIds = \Auth::user()->role->widgets->pluck('id')->intersect($widgets->pluck('id'));

        foreach ($config['tabs'] as $tabIndex => $tab) {
            //Remove disable or unassigned widgets
            $tabWidgets = collect($config['tabs'][$tabIndex]['widgets'])
                ->reject(function ($widget) use ($allowedWidgetIds) {
                    return !$allowedWidgetIds->contains($widget['id']);
                });

            //Lets add new widgets
            $newWidgetsIds = $allowedWidgetIds->diff($tabWidgets->pluck('id'));
            foreach ($newWidgetsIds as $widgetsId) {
                $tabWidgets->push($widgets[$widgetsId]);
            }
            $config['tabs'][$tabIndex]['widgets'] = $tabWidgets->values()->toArray();
        }
        // return config
        return response()->json($config);
    }

    private function defaultConfig()
    {
        $widgets = Widget::enabled();
        $tabs = [
            'Dashboard' => ['Users'],
        ];
        $config = [
            'tabs' => [],
            'syncGetUrl' => '/nvd-dashboard/load-config',
            'syncPostUrl' => '/nvd-dashboard/save-config',
            'gridsterOpts' => [
                'columns' => 20,
                'margins' => [5, 5],
                'defaultSizeX' => 6,
                'defaultSizeY' => 6,
                'outerMargin' => true,
                'pushing' => true,
                'floating' => true,
                'draggable' => ['enabled' => true, 'handle' => '.drag-handle'],
                'resizable' => [
                    'enabled' => true,
                    'handles' => ['n', 'e', 's', 'w', 'se', 'sw', 'ne', 'nw'],
                ],
            ],
        ];

        foreach ($tabs as $tabName => $enabledWidgets) {
            $tab = ['title' => $tabName, 'widgets' => []];
            foreach ($widgets as $widget) {
                $widget->enabled = in_array($widget->title, $enabledWidgets) ? true : false;
                $tab['widgets'][] = $widget->toArray();
            }
            $config['tabs'][] = $tab;
        }

        return $config;
    }

    public function saveConfig()
    {
        \Auth::user()->saveDashboardSettings(request('config'));
        return response("Saved");
    }

}