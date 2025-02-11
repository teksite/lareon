<?php

namespace Lareon\CMS\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Lareon\CMS\App\Models\Permission;

class GatesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {

    }

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->bootGates();

    }

    public function bootGates(): void
    {
        if (Schema::hasTable('auth_permissions') && Schema::hasTable('auth_roles')) {
            if (!cache()->has('allPermissionsGates')) cache()->forever('allPermissionsGates', Permission::query()->select('title' ,'id')->get());
            $permissions = Permission::query()->select('title' ,'id')->get();//cache()->get('allPermissionsGates');
            foreach ($permissions as $permission) {
                Gate::define($permission->title, function ($user) use ($permission) {
                    return $user->hasPermission($permission->title);
                });
            }
        }
    }
}
