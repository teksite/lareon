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
            ['title' => 'admin', 'description' => 'access to cms dashboard'],
            ['title' => 'admin.permission.read', 'description' => 'read all permissions in the cms dashboard'],
            ['title' => 'admin.permission.create', 'description' => 'create a new permission in the cms dashboard'],
            ['title' => 'admin.permission.update', 'description' => 'update a permission in the cms dashboard'],
            ['title' => 'admin.permission.delete', 'description' => 'delete a permission in the cms dashboard'],

            ['title' => 'admin.role.read', 'description' => 'read all roles in the cms dashboard'],
            ['title' => 'admin.role.create', 'description' => 'create a new role in the cms dashboard'],
            ['title' => 'admin.role.update', 'description' => 'update a role in the cms dashboard'],
            ['title' => 'admin.role.delete', 'description' => 'delete a role in the cms dashboard'],

            ['title' => 'admin.user.read', 'description' => 'read all users in the cms dashboard'],
            ['title' => 'admin.user.create', 'description' => 'create a new user in the cms dashboard'],
            ['title' => 'admin.user.update', 'description' => 'update a user in the cms dashboard'],
            ['title' => 'admin.user.delete', 'description' => 'delete a user in the cms dashboard'],

            ['title' => 'admin.setting', 'description' => 'can read and edit overall site setting'],

            ['title' => 'admin.log.read', 'description' => 'read all logs in the cms dashboard'],
            ['title' => 'admin.log.delete', 'description' => 'delete content of a log file in the cms dashboard'],

            ['title' => 'admin.cache.read', 'description' => 'read all logs in the cms dashboard'],
            ['title' => 'admin.cache.create', 'description' => 'store a in the cms dashboard'],
            ['title' => 'admin.cache.delete', 'description' => 'delete content of a log file in the cms dashboard'],

            ['title' => 'admin.tag.edit', 'description' => 'can moderate tags'],

            ['title' => 'admin.seo.edit', 'description' => 'can edit seo of site and pages'],

        ]);
    }
}
