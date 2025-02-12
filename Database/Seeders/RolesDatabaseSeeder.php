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
            ['title'=>'owner', 'description'=>'owner of the app', 'hierarchy'=>1 ],
            ['title'=>'administrator', 'description'=>'full control', 'hierarchy'=>1 ],
            ['title'=>'admin', 'description'=>'full control but not on administrator users', 'hierarchy'=>5 ],
            ['title'=>'user', 'description'=>'regular client with client\'s permissions', 'hierarchy'=>20 ],
            ['title'=>'ban', 'description'=>'has no permission', 'hierarchy'=>100 ],

        ]);

        Role::query()->firstWhere(['title'=>'owner'])?->permissions()->attach(Permission::all()->pluck('id')->toArray());
        Role::query()->firstWhere(['title'=>'administrator'])?->permissions()->attach(Permission::all()->pluck('id')->toArray());
        Role::query()->firstWhere(['title'=>'admin'])?->permissions()->attach(Permission::all()->pluck('id')->toArray());
        Role::query()->firstWhere(['title'=>'user'])?->permissions()->attach(Permission::where('title','LIKE', 'clinet%')->pluck('id')->toArray());
    }
}
