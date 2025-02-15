<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\Role;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;
use Teksite\Lareon\Services\SystemMonitoringServices;

class SystemUsageLogic
{

    public function getUsage()
    {
        return app(ServiceWrapper::class)(function () {
            return (new SystemMonitoringServices())->getSystemUsage();
        });
    }


}
