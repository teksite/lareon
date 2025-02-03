<?php

namespace Teksite\Lareon\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Teksite\Lareon\Facade\Lareon;
use Teksite\Lareon\Services\LareonServices;

trait CmsCommandsTrait
{

    /**
     * @throws \Exception
     */
    protected function resolveStubPath($stub)
    {
        $path = app('cms.stubs') . $stub;

        return file_exists($path) ? $path : throw new \Exception ($stub . 'isn not exist in the path: ', $path);
    }

    protected function setPath($relativePath, string $format = 'php'): string
    {
        $absolutePath = base_path($relativePath);

        $this->existOrCreate($relativePath);

        return str_replace('\\', '/', $relativePath) . '.' . $format;
    }

    protected function setNamespace($name, $relative): string
    {
        $namespace = Lareon::cmsNamespace($relative);
        return $namespace . '\\' . str_replace('/', '\\', $name);
    }

    protected function existOrCreate(string $path): void
    {
        if (!dirname($path)) {
            mkdir(dirname($path), 0755, true, true);
        }
    }


    protected function viewPath($path= '')
    {
        return Lareon::cmsViewPath($path);

    }

    protected function qualifyModel(string $model)
    {
        $model = ltrim($model, '\\/');

        $model = str_replace('/', '\\', $model);

        $thisNamespace = Str::finish($this->rootNamespace() ,'\\');
        $appNamespace = app()->getNamespace();
        $cmsNamespace = Lareon::cmsNamespace();

        if (Str::startsWith($model, $thisNamespace)) {
            return $model;
        }
        if (Str::startsWith($model, $appNamespace)) {
            return $model;
        }
        if (Str::startsWith($model, $cmsNamespace)) {
            return $model;
        }
        return Lareon::cmsNamespace('App\\Models\\'.$model);
    }

    protected function rootNamespace()
    {
        return Lareon::cmsNamespace('App');
    }

    public function cmsNamespace(string $path=null)
    {
       return Lareon::cmsNamespace($path);
    }
}
