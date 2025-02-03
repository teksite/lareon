<?php

namespace Teksite\Lareon\Services;

use Teksite\Extralaravel\Traits\StudyPathNamespace;

class LareonServices
{
    use StudyPathNamespace;

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

        $relativePath = $this->normalizePath($mainPath . ($path ? '/' . $path : ''));
        return $absolute ? base_path($relativePath) : $relativePath;
    }

    public function cmsNamespace(?string $path = null): string
    {
        $mainNamespace = config('lareon.namespace', "Lareon\CMS");

        return $this->normalizeNamespace($mainNamespace  . ($path ? '\\' . trim($path, "/\\") : ''));
    }

    public function cmsViewPath(?string $path = null): string
    {
        return $this->cmsPath('resources/views' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }


}
