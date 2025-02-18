<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Authorize;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Http\Requests\Admin\NewPermissionRequest;
use Lareon\CMS\App\Http\Requests\Admin\UpdatePermissionRequest;
use Lareon\CMS\App\Logic\PermissionLogic;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Lareon\Facade\WebResponse;

class PermissionsController extends Controller implements HasMiddleware
{
    public function __construct(public PermissionLogic $logic){

    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.permission.read'),
            new Middleware('can:admin.permission.create', only: ['create', 'store']),
            new Middleware('can:admin.permission.edit', only: ['edit', 'update']),
            new Middleware('can:admin.permission.delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions=$this->logic->getAll()->result;

        return view('lareon::admin.pages.authorize.permissions.index' , compact('permissions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->action($this->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewPermissionRequest $request)
    {
        $result=$this->logic->register($request->validated());
        return WebResponse::byResult($result)->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('lareon::admin.pages.authorize.permissions.edit' , compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $result=$this->logic->change($request->validated() , $permission);
        return WebResponse::byResult($result, route('admin.authorize.permissions.edit' , $permission))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $result=$this->logic->delete($permission);
        return WebResponse::byResult($result,route('admin.authorize.permissions.index'))->go();
    }
}
