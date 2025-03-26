<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Teksite\Authorize\Models\Role;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class RoleLogic
{
    /**
     * @param mixed $fetchData
     * @return ServiceResult
     */
    public function get(mixed $fetchData = []) : ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Role::class, ['title'], ...$fetchData);
        });
    }

    /**
     * @param array $input
     * @return ServiceResult
     */
    public function register(array $input) : ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            $role = Role::query()->create(Arr::except($input, ['permissions']));
            $role->permissions()->attach($input['permissions']);
            $this->cacheHandler();
            return $role;
        });
    }

    /**
     * @param array $input
     * @param Role $role
     * @return ServiceResult
     */
    public function change(array $input, Role $role) : ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($input, $role) {
            $role->update(Arr::except($input, ['permissions']));
            $role->permissions()->sync($input['permissions']);
            $this->cacheHandler();
            return $role;
        });
    }

    /**
     * @param Role $role
     * @return ServiceResult
     */
    public function delete(Role $role): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($role) {
            $role->delete();
            $this->cacheHandler();
        });
    }

    public function getRoleBaseHirarichy($user )
    {

    }


    /**
     * @return void
     */
    private function cacheHandler(): void
    {
        cache()->forget('allRolesGates');
        cache()->forever('allRolesGates', Role::all(['id', 'title']));
    }
}

