<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Authorization;

use Illuminate\Http\Request;
use Lareon\CMS\App\Http\Controllers\Controller;
use Lareon\CMS\App\Logic\PermissionLogic;
use Teksite\Authorize\Models\Permission;

class PermissionsController extends Controller
{
    public function __construct(public PermissionLogic $logic)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logic=$this->logic->get();
        return view('Lareon::admin.pages.authorization.permissions.index', compact('logic'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
