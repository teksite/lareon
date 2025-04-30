<?php

namespace Lareon\CMS\App\Http\Controllers\Ajax\Admin\Authorization;

use Illuminate\Http\Request;
use Lareon\CMS\App\Http\Controllers\Controller;
use Lareon\CMS\App\Logic\RoleLogic;
use Teksite\Lareon\Facade\JsonResponse;

class RolesController extends Controller
{
    public function __construct(public RoleLogic $logic)
    {
    }

    public function get(Request $request)
    {
        $validated=$request->validate([
            'title'=>'required|string|min:3|max:255',
        ]);
        $result=$this->logic->find($validated['title']);

        return JsonResponse::byResult($result)->reply();
    }
}
