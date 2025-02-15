<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Teksite\Handler\Actions\ServiceWrapper;

class LogsLogic
{
    public function getAll() : Collection
    {
        $filesInfo=File::files(base_path('storage/logs'));
        return collect($filesInfo)->map(function ($file) {
            return basename($file);
        });
    }

    public function delete($log)
    {

        return app(ServiceWrapper::class)(function () use ($log) {
              File::put(base_path('storage/logs/' . $log) ,'');
        });
    }

    public function getContent(?string $file =null)
    {
        $default = request()->get("log", 'laravel.log');
        $file ??= $default;
        return File::get(base_path('storage/logs/'.$file));

    }
}

