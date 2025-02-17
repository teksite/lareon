<?php

namespace Lareon\CMS\App\Http\Controllers\Ajax\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\CMS\App\Logic\SystemUsageLogic;
use Teksite\Lareon\Facade\JsonResponse;
use Teksite\Lareon\Facade\WebResponse;

class SystemUsagesController extends Controller implements HasMiddleware
{
    public function __construct(public SystemUsageLogic $logic)
    {
    }


    public static function middleware()
    {
        return [
            new Middleware('can:admin.info.read'),
        ];
    }

    public function get()
    {
        $result=$this->logic->getUsage();
        return JsonResponse::byResult($result)->reply();
    }
}
