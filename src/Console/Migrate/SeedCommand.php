<?php

namespace Teksite\Lareon\Console\Migrate;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Teksite\Lareon\Console\BasicMigrator;
use Teksite\Lareon\Contract\MigrationContract;
use Teksite\Lareon\Traits\Migration\LareonMigrationTrait;
use Teksite\Module\Facade\Module;
use Teksite\Module\Traits\ModuleNameValidator;

class SeedCommand extends BasicMigrator implements MigrationContract
{
    use LareonMigrationTrait;

    protected $signature = 'lareon:seed
        {--module : The module to seed.}
        {--only=false : only migration manged by lareon}

    ';

    protected $description = 'Seed the module';

    protected string $type = 'Seed';


    public function runTheCommand(): void
    {
        $this->seeding();
    }
}
