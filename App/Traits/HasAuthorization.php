<?php

namespace Lareon\CMS\App\Traits;

use Illuminate\Support\Collection;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\Role;
use Lareon\CMS\App\Models\User;

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
        if (is_string($roles)) {
            $roles = Role::query()->where('title', $roles)->first('id');
        }elseif (is_int($roles)) {
            $roles = Role::find($roles);
        }elseif ($roles instanceof Role) {
            $roles = Role::query()->find($roles ,'id');
        }

        return !!collect($roles)->pluck('id')->intersect($this->roles->pluck('id'))->count();
    }
    public function hasPermission(string|int|Permission $permission): bool
    {

        if (is_string($permission)) {
            $permission = Permission::query()->where('title', $permission)->with('roles', function ($query){
                $query->select(['title', 'id']);
            })->first('id');
        }elseif (is_int($permission)) {
            $permission = Permission::query()->where('id', $permission)->with('roles', function ($query){
                $query->select(['title', 'id']);
            })->first('id');
        }
        if($permission->exists ===false) return false;
        return $this->permissions->contains('id', $permission->id) || $this->hasRole($permission->roles);
    }

    public function allPermission()
    {
        return $this->roles->map(function ($role) {
           return $role->permissions;
        })->flatten()->merge($this->permissions)->unique('id');
    }


}


