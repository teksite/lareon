<?php

namespace Lareon\CMS\App\Service;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Teksite\Module\Facade\Module;

class MenuHelper
{
    public static function getMenu()
    {
        $menuItems = config('menu.cms');
        $modulesMenus = self::getModulesMenus();


        $allMenus = array_merge($menuItems, $modulesMenus);


        return collect($allMenus)->sortBy('position')->map(function ($menu) {
            return self::formatMenuItem($menu);
        })->toArray();
    }

    private static function getModulesMenus()
    {
        $modulesPath = base_path('Lareon/Module');
        $menus = [];

        foreach (Module::all() as $module) {

        }

        return $menus;
    }

    private static function formatMenuItem($menu)
    {
        $formattedMenu = [
            'label' => __($menu['label']),
            'icon' => $menu['icon'] ?? 'circle',
            'href' => isset($menu['route']) ? route($menu['route']) : '#',
            'is_active' => isset($menu['is_active']) && request()->routeIs([$menu['is_active']]),
        ];

        if (isset($menu['sub']) && is_array($menu['sub'])) {
            $formattedMenu['sub'] = collect($menu['sub'])->map(function ($sub) {
                return [
                    'label' => __($sub['label']),
                    'href' => isset($sub['route']) ? route($sub['route']) : '#',
                    'is_active' =>
                        (isset($sub['is_active']) && request()->routeIs([$sub['is_active']])) ||
                        (isset($sub['route']) && Route::is($sub['route'])),
                ];
            })->toArray();
        }

        return $formattedMenu;
    }
}
