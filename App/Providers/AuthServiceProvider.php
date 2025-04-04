<?php

namespace Lareon\CMS\App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Teksite\Authorize\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       \Teksite\Authorize\Models\Role::class => \Lareon\CMS\App\Policies\RolePolicy::class,
       \Lareon\CMS\App\Models\User::class => \Lareon\CMS\App\Policies\UserPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

    }
}
