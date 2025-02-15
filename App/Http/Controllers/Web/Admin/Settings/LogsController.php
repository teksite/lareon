<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\CMS\App\Logic\LogsLogic;
use Lareon\CMS\App\Logic\PermissionLogic;
use Teksite\Lareon\Facade\WebResponse;

class LogsController extends Controller implements HasMiddleware
{
    public function __construct(public LogsLogic $logic){

    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.log.read'),
            new Middleware('can:admin.log.delete', only: ['destroy']),
        ];
    }

    public function show()
    {
        $files=$this->logic->getAll();
        $content = $this->logic->getContent();
        return view('lareon::admin.pages.settings.logs.show', compact('files' ,'content'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'log'=>Rule::in($this->logic->getAll())
        ]);

        $result =  $this->logic->delete(request()->log);
        return WebResponse::byResult($result)->go();

    }
}
