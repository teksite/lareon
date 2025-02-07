<?php

namespace Lareon\CMS\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\Role;
use Lareon\CMS\App\Models\User;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->insert([
            ['title'=>'owner', 'description'=>'owner of the app' ],
            ['title'=>'administrator', 'description'=>'full control' ],
            ['title'=>'admin', 'description'=>'full control but not on administrator users' ],
            ['title'=>'user', 'description'=>'regular client with client\'s permissions' ],
            ['title'=>'ban', 'description'=>'has no permission' ],

        ]);

        Role::query()->firstWhere(['title'=>'owner'])?->permissions()->attach(Permission::all()->pluck('id')->toArray());
    }
}
