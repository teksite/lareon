<?php

namespace Lareon\CMS\App\Service;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Teksite\Module\Facade\Module;

class MenuHelper
{
    public static function getMenu(): array
    {
        $menu = Config::get('menu.cms', []);


        foreach (config('modules.modules', []) as $module=>$provider) {
            $moduleMenuFile = base_path("Lareon/Modules/{$module}/Config/menu.php");

            if (file_exists($moduleMenuFile)) {
                $moduleMenu = require $moduleMenuFile;

                if (isset($moduleMenu['cms'])) {
                    $menu = self::mergeMenus($menu, $moduleMenu['cms']);
                }
            }
        }

        return self::filterMenuByPermission($menu);
    }

    private static function mergeMenus(array $baseMenu, array $moduleMenu): array
    {
        foreach ($moduleMenu as $newItem) {

            $found = false;

            foreach ($baseMenu as &$existingItem) {
                if ($existingItem['label'] === $newItem['label']) {
                    if (isset($newItem['sub'])) {
                        $existingItem['sub'] = array_merge($existingItem['sub'] ?? [], $newItem['sub']);
                    }
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $baseMenu[] = $newItem;
            }
        }

        return $baseMenu;
    }

    private static function filterMenuByPermission(array $menu): array
    {
        return array_filter($menu, function ($item) {
            if (isset($item['permission']) && !Gate::allows($item['permission'])) {
                return false;
            }

            if (isset($item['sub'])) {
                $item['sub'] = self::filterMenuByPermission($item['sub']);
            }

            return true;
        });
    }
}
