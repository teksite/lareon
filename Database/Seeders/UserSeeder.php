<?php

namespace Lareon\CMS\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = User::factory()->create([
            'name' => 'sina zangibad',
            'email' => 'sina.zangiband@gmail.com',
            'phone' => '09126037279',
        ]);
        $administrator->markPhoneAsVerified();
        $administrator->markEmailAsVerified();

        $administrator->permissions()->attach(Permission::all(['id']));
        $administrator->roles()->attach([2]);
    }
}
