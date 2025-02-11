<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\Role;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class RoleLogic
{

    public function getAll(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Role::class, ['title'], ...$fetchData);
        });
    }

    public function register(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            $role = Role::query()->create(Arr::except($input, ['permissions']));
            $role->permissions()->attach($input['permissions']);
            $this->cacheHandler();
            return $role;
        });
    }

    public function change(array $input, Role $role)
    {
        return app(ServiceWrapper::class)(function () use ($input, $role) {
            $role->update(Arr::except($input, ['permissions']));
            $role->permissions()->sync($input['permissions']);
            $this->cacheHandler();
            return $role;
        });
    }

    public function delete(Role $role)
    {
        return app(ServiceWrapper::class)(function () use ($role) {
            $role->delete();
            $this->cacheHandler();

        });
    }


    private function cacheHandler()
    {
        cache()->forget('allRolesGates');
        cache()->forever('allRolesGates', Role::all(['id', 'title']));
    }
}
