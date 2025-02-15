<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\CMS\App\Logic\CachesLogic;
use Teksite\Lareon\Facade\WebResponse;

class CachesController extends Controller implements HasMiddleware
{
    public function __construct(public CachesLogic $logic)
    {

    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.cache.read'),
            new Middleware('can:admin.cache.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $files = $this->logic->getAll();
        $content = $this->logic->getContent();
        return view('lareon::admin.pages.settings.logs.show', compact('files', 'content'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'log' => Rule::in($this->logic->getAll())
        ]);

        $result = $this->logic->delete(request()->log);
        return WebResponse::byResult($result)->go();

    }
}
