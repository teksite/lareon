<?php

namespace Lareon\CMS\App\Services;

use Teksite\Module\Facade\Module;

class MenuService
{
    public static function getAdminMenu()
    {
        $menuItems = [];
        $cmsConig = cms_path('config/admin-menu.php');
        if (file_exists($cmsConig)) {
            $moduleMenu = include $cmsConig;
            $menuItems = array_merge($menuItems, $moduleMenu);
        }

        $modules = Module::all();

        foreach ($modules as $module) {
            $menuFile = module_path($module, 'config/admin-menu.php');
            if (file_exists($menuFile)) {
                $moduleMenu = include $menuFile;
                $menuItems = array_merge($menuItems, $moduleMenu);
            }
        }

        // ادغام زیرمجموعه‌ها از ماژول‌های دیگه
        return self::mergeSubMenus($menuItems);
    }

    private static function mergeSubMenus($menuItems)
    {
        $menuMap = [];

        foreach ($menuItems as $item) {
            if (isset($item['children'])) {
                if (isset($menuMap[$item['title']])) {
                    $menuMap[$item['title']]['children'] = array_merge(array_merge($menuMap[$item['title']]['children'], $item['children']));
                } else {
                    $menuMap[$item['title']] = $item;
                }
            } else {
                $menuMap[$item['title']] = $item;
            }
        }

        return array_values($menuMap);
    }
}
