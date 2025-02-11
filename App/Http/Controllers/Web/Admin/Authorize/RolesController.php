<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Authorize;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Http\Requests\Admin\NewRoleRequest;
use Lareon\CMS\App\Http\Requests\Admin\UpdateRoleRequest;
use Lareon\CMS\App\Logic\RoleLogic;
use Lareon\CMS\App\Models\Role;
use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Lareon\Facade\WebResponse;

class RolesController extends Controller implements HasMiddleware
{
    public function __construct(public RoleLogic $logic){

    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.role.read'),
            new Middleware('can:admin.role.create', only: ['create', 'store']),
            new Middleware('can:admin.role.update', only: ['edit', 'update']),
            new Middleware('can:admin.role.delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles=$this->logic->getAll()->result;
        return view('lareon::admin.pages.authorize.roles.index' , compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lareon::admin.pages.authorize.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewRoleRequest $request)
    {
        $result=$this->logic->register($request->validated());
        return WebResponse::byResult($result)->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('lareon::admin.pages.authorize.roles.edit' , compact('role'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $result=$this->logic->change($request->validated() , $role);
        return WebResponse::byResult($result, ['route'=>route('admin.authorize.roles.edit' , $role)])->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $result=$this->logic->delete($role);
        return WebResponse::byResult($result, ['route'=>route('admin.authorize.roles.index')])->go();
    }
}
