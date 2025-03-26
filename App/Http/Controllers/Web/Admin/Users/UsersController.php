<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Http\Controllers\Controller;
use Lareon\CMS\App\Http\Requests\Admin\NewUserRequest;
use Lareon\CMS\App\Http\Requests\Admin\UpdateUserRequest;
use Lareon\CMS\App\Logic\UserLogic;
use Lareon\CMS\App\Logic\UserMetaLogic;
use Lareon\CMS\App\Models\User;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Lareon\Facade\WebResponse;

class UsersController extends Controller implements HasMiddleware
{

    public function __construct(public UserLogic $logic , public UserMetaLogic $metaLogic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.user.read'),
            new Middleware('can:admin.user.create', only: ['create', 'store']),
            new Middleware('can:admin.user.edit', only: ['edit', 'update']),
            new Middleware('can:admin.user.delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res=$this->logic->get();
        $users=$res->result;
        return view('lareon::admin.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lareon::admin.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewUserRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res, route('admin.users.edit', $res->result))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
         if(Route::has('users.show')){
             return redirect()->route('users.show', compact('user'));
         }
         abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $meta=$this->metaLogic->get($user ,'social' ,'value')->result;
        return view('lareon::admin.pages.users.edit', compact('user' ,'meta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $response_user = $this->logic->change($request->validated() , $user);
        $response_meta = $this->metaLogic->registerOrChange($user , $request->validated('meta'));
        $res=new ServiceResult($response_meta->success &&  $response_user->success , null);
        return WebResponse::byResult($res, route('admin.users.edit', $user))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
      //  Gate::authorize('delete', $role);

        $res = $this->logic->delete($user);
        return WebResponse::byResult($res, route('admin.users.index'))->go();
    }
}
