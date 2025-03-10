<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;


if (!function_exists('cms_path')) {
    function cms_path(?string $path = null, bool $absolute = true ): ?string
    {
        $mainPath = config('cms-setting.main_path' ,'Lareon') . DIRECTORY_SEPARATOR .  config('cms-setting.cms.directory', 'CMS');

        $relativePath = normalizePath($mainPath . ($path ? '/' . $path : ''));

        return $absolute ? base_path($relativePath) : $relativePath;
    }

}


if (!function_exists('cms_namespace')) {

    function cms_namespace(?string $path = null): string
    {
        $moduleBaseNamespace = config('module.module.namespace' ,'Lareon\CMS');

        $path=$path ? str_replace('/', '\\', $path) :null;

        return $path
            ? $moduleBaseNamespace .'\\'. $path
            : $moduleBaseNamespace;
    }
}



if (!function_exists('dateAdapter')) {
    function dateAdapter($time, $format = "Y-m-d H:i"): ?string
    {
        if (is_null($time)) return null;
        return config('app.locale') == 'fa' ? Jalalian::forge(Carbon::parse($time))->format($format) : Carbon::parse($time)->format($format);
    }
}
