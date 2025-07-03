<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;


if (!function_exists('cms_path')) {
    function cms_path(?string $path = null, bool $absolute = true): ?string
    {
        $mainPath = config('cms-setting.main_path', 'Lareon') . DIRECTORY_SEPARATOR . config('cms-setting.cms.directory', 'CMS');

        $relativePath = normalizePath($mainPath . ($path ? '/' . $path : ''));

        return $absolute ? base_path($relativePath) : $relativePath;
    }

}


if (!function_exists('cms_namespace')) {

    function cms_namespace(?string $path = null): string
    {
        $moduleBaseNamespace = config('cms-setting.cms.namespace', 'Lareon\CMS');

        $path = $path ? str_replace('/', '\\', $path) : null;
        $path = trim($path, '\\');
        return $path
            ? $moduleBaseNamespace . '\\' . $path
            : $moduleBaseNamespace;
    }
}


if (!function_exists('lareonModules')) {
    /**
     * @param bool $active
     * @return array
     */
    function lareonModules(bool $active = true): array
    {
        $modulesArray = [];
        foreach (get_module_bootstrap() ?? [] as $name => $data) {
            $type = $data['type'] ?? 'self';
            if ($type !== 'lareon') continue;

            if ($active) {
                if ($data['active']) $modulesArray[$name] = $data;
            } else {
                $modulesArray[$name] = $data;
            }
        }
        return $modulesArray;
    }
}


if (!function_exists('dateAdapter')) {
    function dateAdapter($time, $format = "Y-m-d H:i"): ?string
    {
        if (is_null($time)) return null;
        return config('app.locale') == 'fa' ? Jalalian::forge(Carbon::parse($time))->format($format) : Carbon::parse($time)->format($format);
    }
}


if (!function_exists('dateToJalali')) {
    /**
     * To convert Gregorian date-time to Jalali
     *
     * @param $gregorianDateTime
     * @param string|null $format
     * @return string|null
     */
    function dateToJalali($gregorianDateTime, ?string $format = "Y/m/d H:i:s"): ?string
    {
        try {
            $carbonDate = Carbon::parse($gregorianDateTime);
            return Jalalian::fromCarbon($carbonDate)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('dateToGregorian')) {
    /**
     * To convert Jalali date-time to Gregorian
     *
     * @param $jalaliDate
     * @param string|null $format
     * @return string|null
     */
    function dateToGregorian($jalaliDate, ?string $format = "Y-m-d H:i:s"): ?string
    {

        try {
            $jalaliDateTime = str_replace('/', '-', $jalaliDate);

            $hasTime = preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}(:\d{2})?/', $jalaliDateTime);

            if ($hasTime) {
                $carbonDate = Jalalian::fromFormat('Y-m-d H:i:s', $jalaliDateTime)->toCarbon();
            } else {
                $carbonDate = Jalalian::fromFormat('Y-m-d', $jalaliDateTime)->toCarbon();
            }
            return !is_null($format) ? $carbonDate->format($format) : $carbonDate;
        } catch (\Exception $e) {
            return null;
        }

    }
}

