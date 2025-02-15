<?php

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

if (!function_exists('cms_path')) {
    function cms_path(?string $path = null, bool $absolute = true ): ?string
    {
        $mainPath = config('lareon.main_path') && config('lareon.cms_directory')
            ? config('lareon.main_path') . DIRECTORY_SEPARATOR . config('lareon.cms_directory')
            : "Lareon/CMS";
        $relativePath = normalizePath($mainPath . ($path ? '/' . $path : ''));
        return $absolute ? base_path($relativePath) : $relativePath;
    }

}


if (!function_exists('cms_namespace')) {
    function cms_namespace(?string $path = null): string
    {
        // Add any additional logic for your module namespaces
        $cmsBaseNamespace = config('lareon.namespace'). '\\';
        return $path
            ? $cmsBaseNamespace . $path
            : $cmsBaseNamespace;
    }
}


if (!function_exists('dateAdapter')) {
    function dateAdapter($time, $format = "Y-m-d H:i"): ?string
    {
        if (is_null($time)) return null;
        return config('app.locale') == 'fa' ? Jalalian::forge(Carbon::parse($time))->format($format) : Carbon::parse($time)->format($format);
    }
}


if (!function_exists('stringifyName')) {
    function stringifyName(string $name): ?string
    {
        if(str_contains($name , '[' )){
            $stringifyName=str_replace('][','.', $name);
            $stringifyName=str_replace('[','.', $stringifyName);
            $stringifyName=str_replace(']','', $stringifyName);
        }else{
            $stringifyName=$name;
        }
        return $stringifyName;
    }
}
