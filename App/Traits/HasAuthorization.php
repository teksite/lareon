<?php

namespace Lareon\CMS\App\Traits;

use Illuminate\Support\Collection;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\Role;

trait HasAuthorization
{
    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'model', 'auth_permission_models');

    }

    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'auth_role_models');
    }

    public function syncPermissions(array $permissions, $detaching = true)
    {
        if ($detaching) return $this->permissions()->sync($permissions);

        return $this->permissions()->syncWithoutDetaching($permissions);
    }

    public function assignRole(array $roles, $detaching = true)
    {
        if ($detaching) return $this->roles()->sync($roles);

        return $this->roles()->syncWithoutDetaching($roles);
    }



    public function hasRole(string|int|array|Role|Collection $roles): bool
    {
        if (is_int($roles)) {
            $roles = Role::query()->where('title', $roles)->first('id');
        }

        if (is_int($roles)) {
            $roles = Role::find($roles);
        }

        if ($roles instanceof Role) {
            $roles = Role::query()->find($roles ,'id');
        }
        return !!$roles->intersect($this->roles->pluck('id'))->all();
    }
    public function hasPermission(string|int|Permission $permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::query()->where('title', $permission)->with('roles')->first('id');
        }
        if ($permission instanceof Permission) {
            $permission = $permission->with('roles')->first();
        }
        return $this->permissions->contains('id', $permission->id) || $this->hasRole($permission->roles);
    }
}


