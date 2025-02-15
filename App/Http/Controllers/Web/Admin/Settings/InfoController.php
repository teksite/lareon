<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\CMS\App\Logic\SystemUsageLogic;

class InfoController extends Controller implements HasMiddleware
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

    public function index()
    {
        $usages=$this->logic->getUsage();
        return view('lareon::admin.pages.settings.info.index',compact('usages'));
    }

}
