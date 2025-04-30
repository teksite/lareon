<?php

namespace Lareon\CMS\App\Http\Controllers\Ajax\Admin\Users;

use Illuminate\Http\Request;
use Lareon\CMS\App\Http\Controllers\Controller;
use Lareon\CMS\App\Logic\UserLogic;
use Lareon\CMS\App\Models\User;
use Teksite\Lareon\Facade\JsonResponse;

class UsersController extends Controller
{
    public function __construct(public UserLogic $logic)
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
