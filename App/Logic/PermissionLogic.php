<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Lareon\CMS\App\Models\Permission;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;


class PermissionLogic
{
    public function getAll(mixed $fetchData=[])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Permission::class ,['title'] ,...$fetchData);
        });
    }

    public function register(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            $permission = Permission::query()->create($input);
            $this->cacheHandler();
            return $permission;
        });
    }

    public function change(array $input, Permission $permission)
    {
        return app(ServiceWrapper::class)(function () use ($input, $permission) {
            $permission->update($input);
            $this->cacheHandler();
            return $permission;
        });
    }

    public function delete(Permission $permission)
    {
        return app(ServiceWrapper::class)(function () use ($permission) {
            $permission->delete();
            $this->cacheHandler();

        });
    }


    private function cacheHandler()
    {
       cache()->forget('allPermissionsGates');
       cache()->forever('allPermissionsGates' ,Permission::all(['id', 'title']));
    }
}

