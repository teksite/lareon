<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\CMS\App\Http\Requests\Admin\CacheRequest;
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
            new Middleware('can:admin.cache.create', only: ['store']),
        ];
    }

    public function index()
    {
        $caches = $this->logic->getAll();
        return view('lareon::admin.pages.settings.caches.index', compact('caches'));
    }

    public function store(CacheRequest $request)
    {
        $result = $this->logic->save($request->validated('type'));
        return WebResponse::byResult($result)->go();

    }

    public function destroy(CacheRequest $request)
    {
        $result = $this->logic->clear($request->validated('type'));
        return WebResponse::byResult($result)->go();

    }
}
