<?php

namespace Teksite\Lareon\Console\Migrate;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Lareon\CMS\Database\Seeders\CmsDatabaseSeeder;
use Teksite\Lareon\Traits\GeneralCommandsTrait;
use Teksite\Module\Facade\Module;

class SeedCommand extends Command
{
    use GeneralCommandsTrait;

    protected $signature = 'lareon:seed
    {--m|modules : seed modules too}
    {--l|laravel : seed modules too}
    ';

    protected $description = 'Seed the lareon cms';

    protected $type = 'Seed';

    public function handle()
    {
        $this->callSeedLareon();
        if ($this->option('modules')) $this->seedAllModules();
        if ($this->option('laravel')) $this->callLaravelSeed();
    }


    protected function callSeedLareon(): void
    {
        $mainSeeder = CmsDatabaseSeeder::class;
        if (class_exists($mainSeeder)) {

            $this->print(function () use ($mainSeeder) {
                $this->call($mainSeeder);
            }, 'seeding laravel');
            $this->newLine();
        }
    }

    protected function seedAllModules()
    {
        $this->call('module:seed');
    }

    protected function callLaravelSeed(): void
    {
        $this->call('db:seed');
    }
}
