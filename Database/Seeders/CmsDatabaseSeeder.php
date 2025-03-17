<?php

namespace Lareon\CMS\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lareon\CMS\App\Models\User;
use Teksite\Authorize\Models\Permission;
use Teksite\Authorize\Models\Role;

class CmsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
        ]);

        $adminPermissions = Permission::pluck('id')->toArray();

        $clientPermissions = Permission::where('title', 'LIKE', 'client%')->pluck('id')->toArray();

        Role::whereIn('title', ['owner', 'admin', 'administrator'])
            ->each(fn($role) => $role->permissions()->syncWithoutDetaching($adminPermissions));

        Role::where('title', 'user')
            ->each(fn($role) => $role->permissions()->syncWithoutDetaching($clientPermissions));

        if ($user = User::find(1)) $user->assignRole('administrator');

    }
}
