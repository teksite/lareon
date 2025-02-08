<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Authorize;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Http\Requests\Admin\NewPermission;
use Lareon\CMS\App\Logic\PermissionLogic;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionsController extends Controller implements HasMiddleware
{
    public function __construct(public PermissionLogic $logic){

    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.permission.read'),
            new Middleware('can:admin.permission.create', only: ['create', 'store']),
            new Middleware('can:admin.permission.update', only: ['edit', 'update']),
            new Middleware('can:admin.permission.delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lareon::admin.pages.authorize.permissions.index');

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
    public function store(NewPermission $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
