<?php

namespace Lareon\CMS\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Lareon\CMS\App\Models\User;
use Teksite\Authorize\Models\Permission;
use Teksite\Authorize\Models\Role;
use Teksite\Lareon\Facade\Lareon;
use Teksite\Module\Facade\Module;

class CmsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulesPermissionSeederClass=[];
        foreach (Lareon::getModules() as $module){
            $fullClassName = "Lareon\\Modules\\{$module}\\Database\\Seeders\\PermissionsSeeder";
            $mainSeederPath = Module::modulePath($module, "Database/Seeders/PermissionsSeeder.php");
            if (file_exists($mainSeederPath) && class_exists($fullClassName)) {
                $modulesPermissionSeederClass[]=$fullClassName;
            }
        }



        $this->call([
            PermissionsSeeder::class,
            ...$modulesPermissionSeederClass,
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
