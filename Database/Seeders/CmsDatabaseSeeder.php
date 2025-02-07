<?php

namespace Lareon\CMS\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
          PermissionsDatabaseSeeder::class,
          RolesDatabaseSeeder::class,
          UserSeeder::class,
        ]);
    }
}
