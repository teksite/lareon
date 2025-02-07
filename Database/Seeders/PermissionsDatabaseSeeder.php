<?php

namespace Lareon\CMS\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\User;

class PermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->insert([
            ['title'=>'admin', 'description'=>'access to cms dashboard' ],
            ['title'=>'admin.permission.read', 'description'=>'create a new permission cms in cms dashboard' ],
            ['title'=>'admin.permission.create', 'description'=>'create a new permission cms in cms dashboard' ],
            ['title'=>'admin.permission.update', 'description'=>'create a new permission cms in cms dashboard' ],
            ['title'=>'admin.permission.delete', 'description'=>'create a new permission cms in cms dashboard' ],

            ['title'=>'admin.role.read', 'description'=>'create a new role cms in cms dashboard' ],
            ['title'=>'admin.role.create', 'description'=>'create a new role cms in cms dashboard' ],
            ['title'=>'admin.role.update', 'description'=>'create a new role cms in cms dashboard' ],
            ['title'=>'admin.role.delete', 'description'=>'create a new role cms in cms dashboard' ],

            ['title'=>'admin.user.read', 'description'=>'create a new user cms in cms dashboard' ],
            ['title'=>'admin.user.create', 'description'=>'create a new user cms in cms dashboard' ],
            ['title'=>'admin.user.update', 'description'=>'create a new user cms in cms dashboard' ],
            ['title'=>'admin.user.delete', 'description'=>'create a new user cms in cms dashboard' ],

        ]);
    }
}
