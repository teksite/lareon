<?php

namespace Lareon\CMS\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Teksite\Authorize\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Permission::query()->insert([
           [
               'title'=>'admin',
               'description'=>'have access to admin panel',
           ],
           /* Roles */
           [
               'title'=>'admin.role.read',
               'description'=>'have access to read one or all roles',
           ],
           [
               'title'=>'admin.role.create',
               'description'=>'have access to create a new role',
           ],
           [
               'title'=>'admin.role.edit',
               'description'=>'have access to edit roles',
           ],
           [
               'title'=>'admin.role.delete',
               'description'=>'have access to delete roles',
           ],
           /* Permissions */
           [
               'title'=>'admin.permission.read',
               'description'=>'have access to read one or all permissions',
           ],
           [
               'title'=>'admin.permission.create',
               'description'=>'have access to create a new permission',
           ],
           [
               'title'=>'admin.permission.edit',
               'description'=>'have access to edit permissions',
           ],
           [
               'title'=>'admin.permission.delete',
               'description'=>'have access to delete permissions',
           ],
           /* Settings */
           [
               'title'=>'admin.setting.read',
               'description'=>'have access to setting parts and read them',
           ],
           /* Settings */
           [
               'title'=>'admin.setting.info.read',
               'description'=>'have access to information of the app',
           ],
           /* Cache */
           [
               'title'=>'admin.setting.cache.read',
               'description'=>'have access to the caches',
           ],
           [
               'title'=>'admin.setting.cache.create',
               'description'=>'have access to cache determined data',
           ],
           [
               'title'=>'admin.setting.cache.delete',
               'description'=>'have access to delete determined caches',
           ],
           /* Log */
           [
               'title'=>'admin.setting.log.read',
               'description'=>'have access to the logs',
           ],
           [
               'title'=>'admin.setting.log.clear',
               'description'=>'have access to clear log files',
           ],
           [
               'title'=>'admin.setting.log.delete',
               'description'=>'have access to delete log files',
           ],
           /* users */
           [
               'title'=>'admin.user.read',
               'description'=>'have access to read one or all users',
           ],
           [
               'title'=>'admin.user.create',
               'description'=>'have access to create a new user',
           ],
           [
               'title'=>'admin.user.edit',
               'description'=>'have access to edit users',
           ],
           [
               'title'=>'admin.user.delete',
               'description'=>'have access to delete users',
           ],

       ]);
    }
}
