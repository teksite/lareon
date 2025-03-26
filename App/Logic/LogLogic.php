<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Teksite\Authorize\Models\Permission;
use Teksite\Authorize\Models\Role;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class LogLogic
{
    private const LOG_EXTENSION = 'log';
    private const LOG_DIRECTORY = 'logs';


    private function getLogPath(string $name): string
    {
        return storage_path(self::LOG_DIRECTORY . DIRECTORY_SEPARATOR . $name . '.' . self::LOG_EXTENSION);
    }

    /**
     * @return ServiceResult
     */
    public function getLogFiles(): ServiceResult
    {
        return app(ServiceWrapper::class)(function () {
            return collect(Storage::drive('storage')->allFiles(self::LOG_DIRECTORY))
                ->filter(fn($path) => File::extension($path) === self::LOG_EXTENSION)
                ->map(fn($path) => File::name($path))
                ->all();
        }, hasTransaction: false);
    }

    public function getLogContent(string $name = 'laravel'): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($name) {
            $path = $this->getLogPath($name);
            return file_exists($path) ? file_get_contents($path) : null;
        });
    }


    public function clearContent(string $name): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($name) {
            $path = $this->getLogPath($name);
            if (file_exists($path)) file_put_contents($path, '');

        });
    }


    public function delete(string $name): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($name) {
            $path = $this->getLogPath($name);
            if (file_exists($path)) File::delete($path);
        });
    }


}

