<?php

namespace Teksite\Lareon\Services;


use Illuminate\Support\Facades\File;

class LareonServices
{
    private string $bootstrapFile;

    public function __construct()
    {
        $this->bootstrapFile = config('module.registration_file', base_path('bootstrap') . '/modules.php');
    }

    /**
     * Get absolute or relative root of CMS or the specific path.
     *
     * @param string|null $path
     * @param bool $absolute
     * @return string
     */
    public function cmsPath(?string $path = null, bool $absolute = true): string
    {
        $mainPath = config('lareon.main_path') && config('lareon.cms_directory')
            ? config('lareon.main_path') . DIRECTORY_SEPARATOR . config('lareon.cms_directory')
            : "Lareon/CMS";

        $relativePath = normalizePath($mainPath . ($path ? '/' . $path : ''));
        return $absolute ? base_path($relativePath) : $relativePath;
    }

    public function cmsNamespace(?string $path = null): string
    {
        return cms_namespace($path);
    }

    public function cmsViewPath(?string $path = null): string
    {
        return $this->cmsPath('resources/views' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }


    /**
     * @return array|string[]
     */
    public function getModules(): array
    {
        $bootstrapFile = $this->bootstrapFile;
        $modules = [];
        if (File::exists($bootstrapFile)) {
            $bootstrapModule = include $bootstrapFile;
            foreach ($bootstrapModule as $name => $data) {
                if ($data['type'] == 'lareon') {
                    $modules[] = $name;
                }
            }
        }

        return $modules;
    }


}
