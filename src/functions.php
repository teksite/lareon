<?php
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

