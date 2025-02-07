<?php

namespace Teksite\Lareon\Console\Migrate;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Lareon\CMS\Database\Seeders\CmsDatabaseSeeder;
use Teksite\Module\Facade\Module;

class SeedCommand extends Command
{
    protected $signature = 'lareon:seed';

    protected $description = 'Seed the module';

    protected $type = 'Seed';

    public function handle()
    {
        $this->callSeedLareon();
        $this->seedAllModules();
        $this->callDBseed();
    }


    protected function callSeedLareon(): void
    {
        $mainSeeder = CmsDatabaseSeeder::class;
        if (class_exists($mainSeeder)) {
            $this->line("Seeding: {$mainSeeder}");
            $startTime = Carbon::now(); // زمان شروع
            $this->call($mainSeeder);
            $endTime = Carbon::now(); // زمان پایان
            $executionTime = $startTime->diffInMilliseconds($endTime); // محاسبه زمان اجرا
            $this->line(sprintf('%s ................................................................................................ %dms DONE', $mainSeeder, $executionTime));
            $this->newLine();
        }
    }

    protected function seedAllModules()
    {
       $this->call('module:seed');
    }

    protected function callModuleSeeders($module): void
    {
        $mainSeeder = Module::moduleNamespace($module, "\\Database\\Seeders\\{$module}DatabaseSeeder");
        if (class_exists($mainSeeder)) {
            $this->line("Seeding: {$mainSeeder}");
            $startTime = Carbon::now(); // زمان شروع
            $this->call($mainSeeder);
            $endTime = Carbon::now(); // زمان پایان
            $executionTime = $startTime->diffInMilliseconds($endTime); // محاسبه زمان اجرا
            $this->line(sprintf('%s ................................................................................................ %dms DONE', $mainSeeder, $executionTime));
            $this->newLine();
        }
    }


    protected function callDBseed(): void
    {
        $this->call('db:seed');
    }
}
